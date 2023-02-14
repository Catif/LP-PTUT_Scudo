<script setup>
import { provide } from "vue";
import Navbar from "./components/Navbar.vue";
import mitt from 'mitt';
const bus = mitt();
provide('bus', bus)
</script>

<template>
  <div id="content">
    <Navbar />
    <RouterView />
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries.scss";

@media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
  #content {
    display: flex;
  }
}
</style>
