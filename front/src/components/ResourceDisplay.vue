<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps(['resource']);

const videoSrc = ref(null);

var connection = new RTCMultiConnection();
connection.socketURL = "https://scudo-node.herokuapp.com/";

connection.socketCustomEvent = "scudo";
connection.socketMessageEvent = "live";

connection.sdpConstraints.mandatory = {
  OfferToReceiveAudio: false,
  OfferToReceiveVideo: false,
};

connection.session = {
  audio: true,
  video: true,
  oneway: true,
};

connection.iceServers = [
  {
    urls: [
      "stun:stun.l.google.com:19302",
      "stun:stun1.l.google.com:19302",
      "stun:stun2.l.google.com:19302",
      "stun:stun.l.google.com:19302?transport=udp",
    ],
  },
];

connection.videosContainer = document.getElementById("videos-container");
connection.onstream = function (event) {
  videoSrc.value = event.stream;
};

connection.onstreamended = function (event) {
  alert("Broadcast is ended.");

  videoSrc.value = null;

  connection.sdpConstraints.mandatory = {
    OfferToReceiveAudio: false,
    OfferToReceiveVideo: false,
  };
};

connection.onMediaError = function (e) {
  if (e.message === "Concurrent mic process limit.") {
    if (DetectRTC.audioInputDevices.length <= 1) {
      alert("Please select external microphone. Check github issue number 483.");
      return;
    }

    var secondaryMic = DetectRTC.audioInputDevices[1].deviceId;
    connection.mediaConstraints.audio = {
      deviceId: secondaryMic,
    };

    connection.join(connection.sessionid);
  }
};

function openLive() {
  connection.sdpConstraints.mandatory = {
    OfferToReceiveAudio: true,
    OfferToReceiveVideo: true,
  };

  connection.getSocket();
  connection.socket.emit("initUser", {
    role: "viewer",
  });
  connection.socket.emit("runStream");
  connection.join(props.resource.id);
}

function openVideo() {
  videoSrc.value = props.resource.urls.file
}


onMounted(() => {
  if (props.resource.type == 'stream') {
    openLive()
  } else if (props.resource.type == 'video') {
    openVideo()
  }
})
</script>

<template>
  <video v-if="resource.type == 'stream'" id="remoteStream" autoplay muted playsinline :srcObject="videoSrc"></video>
  <video v-if="resource.type == 'video'" id="remoteStream" autoplay muted controls :src="videoSrc"></video>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

video {
  width: 100%;
  aspect-ratio: 4 / 7;
  object-fit: cover;

  vertical-align: bottom;

  @media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
    margin: .75rem 0;
    border-radius: 1.75rem;
  }
}
</style>