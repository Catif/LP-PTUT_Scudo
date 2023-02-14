<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps(['resource']);

const videoSrc = ref(null);

var connection = new RTCMultiConnection();
connection.socketURL = "http://localhost:3000/";

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
  console.log(event);
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

onMounted(() => {
  openLive()
})
</script>

<template>
  <video id="remoteStream" autoplay muted playsinline :srcObject="videoSrc"></video>
</template>