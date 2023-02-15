<script setup>
import { onMounted, ref } from 'vue';
import FloatingAppButton from './ScudoTheming/FloatingAppButton.vue';
import LargeIcon from './ScudoTheming/LargeIcon.vue';

const props = defineProps(['id']);

var stream_id = props.id;

// ===========================
// Variable de configuration
// ===========================

const videoSrc = ref(null);

var mediaRecorder;
var segmentLengthInMs = 500;
var constraints = {
  audio: true,
  video: true,
};
var connection = new RTCMultiConnection();
connection.socketURL = "http://localhost:3000/";

connection.socketCustomEvent = "scudo";
connection.socketMessageEvent = "live";

connection.session = {
  audio: true,
  video: true,
  oneway: true,
};

connection.sdpConstraints.mandatory = {
  OfferToReceiveAudio: false,
  OfferToReceiveVideo: false,
};

connection.onstream = function (event) {
  // console.log(document.getElementById("localVideo"));
  videoSrc.value = event.stream;

  // Création d'un MediaRecorder pour l'enregistrement
  mediaRecorder = new MediaRecorder(event.stream);

  // Envoi des données au serveur à chaque segment créé
  mediaRecorder.addEventListener("dataavailable", (e) => {
    if (connection.socket) {
      connection.socket.emit("recordVideo", {
        video: e.data,
      });
    } else {
      mediaRecorder.stop();
    }
  });
  // Démarrage de l'enregistrement avec la durée d'un segment
  mediaRecorder.start(segmentLengthInMs);
};

// function startStream() {
// }

function stopStream() {
  connection.closeSocket();

  // mediaRecorder.stop();
  videoSrc.value = null;
}

onMounted(() => {
  connection.getSocket();
  connection.socket.emit("initUser", {
    role: "streamer",
    room: stream_id,
  });
  connection.socket.emit("runStream");
  connection.open(stream_id);


})


</script>


<template>
  <div id="record">
    <video id="video" autoplay muted playsinline :srcObject="videoSrc"></video>
    <FloatingAppButton v-if="videoSrc != null" @click="stopStream">
      <LargeIcon>stop</LargeIcon>
    </FloatingAppButton>
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

video {
  width: 100%;
  aspect-ratio: 4 / 7;
  object-fit: cover;

  vertical-align: bottom;


  transform: scaleX(-1);

  @media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
    margin: .75rem 0;
    border-radius: 1.75rem;
  }
}

#record {
  position: relative;

  &>button {
    position: absolute;
    bottom: .75rem;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>