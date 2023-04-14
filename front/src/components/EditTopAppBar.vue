<script setup>
import { useRouter } from 'vue-router';
import { inject } from "vue";
import TopAppBar from './ScudoTheming/TopAppBar.vue';

const props = defineProps(["resource", "title", "mobileOnly", "back"]);
const router = useRouter();
const bus = inject('bus')

function switchMode() {
  alert('fonction non créée')
}

function changeState() {
  bus.emit('TopAppBarModal')
}


function goback() {
  router.back();
}

</script>



<template>
  <TopAppBar title="Édition" :back="back"></TopAppBar>
</template>


<style lang="scss" scoped>
@import "@/assets/scss/media-queries";
@import "@/assets/scss/colors";

header {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  width: 100%;
  display: flex;
  justify-content: space-between;

  background-color: $light-bg-primary;
  border-bottom: 1px solid $light-border;

  &.backless {
    padding-left: 0.75rem;
  }

  section {
    display: flex;
  }

  h1 {
    line-height: 3.5rem;

    font-size: 1.25rem;
    font-weight: 400;

    margin: 0;
  }
}



@media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
  header {
    position: static;
    border-bottom: none;
  }
}
</style>