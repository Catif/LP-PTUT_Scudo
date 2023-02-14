<script setup>
import { onMounted, ref } from 'vue';

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
  <video id="video" autoplay muted playsinline :srcObject="videoSrc"></video>
  <button v-if="videoSrc != null" id="stopRecord" @click="stopStream">Arrêter l'enregistrement</button>
</template>

<style lang="scss" scoped>
video {
  transform: scaleX(-1);
}
</style>