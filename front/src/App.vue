<script setup>
import { provide } from "vue";
import axios from "axios";
import Navbar from "./components/Navbar.vue";
import mitt from 'mitt';

// Variable Globale pour Axios nommé "api"
const API = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    "Content-Type": "application/json",
    // Authorization: "b85abe7b-7412-456f-9b9c-377e21ffcb33",
  },
  mode: 'cors'
});

provide("api", API);

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
