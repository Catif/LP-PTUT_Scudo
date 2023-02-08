<script setup>
import { RouterLink, RouterView } from "vue-router";
import Navbar from "@/components/Navbar.vue";
import Test from "@/components/ScudoTheming/Button.vue";
</script>

<template>
  <header>
    <Navbar />
  </header>
  <Test>oui</Test>

  <RouterView class="container" />
</template>

<style scoped>

</style>
