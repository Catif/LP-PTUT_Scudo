<script setup>
import { onMounted, inject, ref } from 'vue';
import { useSessionStore } from '@/stores/session.js';
import Card from './ScudoTheming/Card.vue';

const Session = useSessionStore();
const props = defineProps(['id']);
const bus = inject('bus')

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
connection.socketURL = "https://scudo-node.herokuapp.com/";

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
  bus.emit('recordOK');

};

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
    token: Session.data.token,
  });
  connection.socket.emit("runStream");
  connection.open(stream_id);

})



bus.on('stopRecord', function () {
  stopStream();
})

</script>


<template>
  <Card>
    <video id="video" autoplay muted playsinline :srcObject="videoSrc"></video>
  </Card>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

video {
  width: 100%;
  // max-width: $content-min-width;
  aspect-ratio: 4 / 7;
  object-fit: cover;

  vertical-align: bottom;


  transform: scaleX(-1);

  @media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
    border-radius: 1.75rem;
  }
}
</style>