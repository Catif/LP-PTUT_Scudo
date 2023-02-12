<script setup>
import Navbar from "./components/Navbar.vue";
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
