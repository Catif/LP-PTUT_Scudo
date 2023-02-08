<script setup>
import { RouterLink, RouterView } from "vue-router";
import Navbar from "@/components/Navbar.vue";
</script>

<template>
  <header>
    <Navbar />
  </header>

  <RouterView class="container" />
</template>

<style scoped>

</style>
