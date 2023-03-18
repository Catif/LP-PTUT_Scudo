<script setup>
import { onMounted, inject, ref, watch } from 'vue';
import Card from './ScudoTheming/Card.vue';
import FilledButton from './ScudoTheming/FilledButton.vue';
import Icon from './ScudoTheming/Icon.vue';
import Title from './ScudoTheming/Title.vue';

const props = defineProps(['resource']);
const bus = inject('bus')

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
  // alert("Broadcast is ended.");

  refresh();

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

function refresh() {
  bus.emit('refreshResource');
}

function openResource() {
  if (props.resource.type == 'stream') {
    openLive()
  } else if (props.resource.type == 'video') {
    if (props.resource.urls.file == '') {
    } else {
      openVideo()
    }
  }
}

onMounted(() => {
  watch(() => props.resource.urls.file, (newValue, oldValue) => {
    openResource();
  })
  openResource();
});
</script>

<template>
  <Card>
    <video v-if="resource.type == 'stream'" id="remoteStream" autoplay muted playsinline :srcObject="videoSrc"></video>
    <video v-if="resource.type == 'video' && props.resource.urls.file != ''" autoplay muted controls
      :src="videoSrc"></video>
    <div id="infoVideoTraitement" v-if="resource.type == 'video' && props.resource.urls.file == ''">
      <Title>Stream terminé, <br>vidéo en cours de traitement</Title>
      <div>
        <FilledButton @click="refresh">
          <Icon>refresh</Icon>
          Réessayer
        </FilledButton>
      </div>
    </div>
  </Card>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

#infoVideoTraitement {
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 90vh;
}

video {
  width: 100%;
  aspect-ratio: 4 / 7;
  object-fit: cover;

  vertical-align: bottom;


  @media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
    border-radius: 1.75rem;
  }
}
</style>