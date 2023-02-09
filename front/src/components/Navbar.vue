<script setup>
import Icon from "./ScudoTheming/Icon.vue";
import { useRoute } from "vue-router";

const route = useRoute();
console.log(route.path);

const listNavMobile = [
  { name: "Home", path: "/", icon: "home" },
  { name: "Upload", path: "/upload", icon: "add_circle" },
  { name: "Test", path: "/test", icon: "chat_bubble" },
];

</script>

<template>
  <nav>
    <router-link v-for="el in listNavMobile" :key="el.path" :to="el.path">
      <Icon :active="route.path == el.path">{{ el.icon }}</Icon>
    </router-link>
  </nav>
</template>

<style lang="scss">
@import "@/assets/scss/colors";

nav {
  position: fixed;
  bottom: 0;
  left: 0;

  display: flex;
  justify-content: space-around;
  align-items: center;

  height: 3.5rem;
  background-color: $neutral-color-98;
  width: 100%;

  a {
    color: $neutral-color-10;
    text-decoration: none;

    &:visited {
      color: inherit;
    }
  }
}
</style>
