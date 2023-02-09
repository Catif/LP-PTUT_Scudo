<script setup>
import Icon from "./ScudoTheming/Icon.vue";
import Text from "./ScudoTheming/Text.vue";

import { useRoute } from "vue-router";

const route = useRoute();
console.log(route.path);

const elementsNav = [
  // Mobile + Desktop
  { name: "Home", path: "/", icon: "home", title: "Accueil", mobile: false },
  { name: "Upload", path: "/upload", icon: "add_circle", title: "Publier", mobile: false },
  { name: "Conversation", path: "/conversation", icon: "chat_bubble", title: "Conversations", mobile: false },

  // Desktop
  { name: "Profil", path: "/profile", icon: "account_circle", title: "Profil", mobile: true },
  { name: "Params", path: "/settings", icon: "settings", title: "Paramètres", mobile: true },
];
</script>

<template>
  <nav>
    <router-link v-for="el in elementsNav" :key="el.name" :to="el.path" v-bind:class="{ mobile: !el.mobile, desktop: el.mobile }">
      <Text
        ><Icon :active="route.path == el.path">{{ el.icon }}</Icon
        ><span class="title">{{ el.title }}</span></Text
      >
    </router-link>
  </nav>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries.scss";

nav {
  position: fixed;
  bottom: 0;
  left: 0;

  width: 100%;

  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;

  background-color: $neutral-color-98;

  .title {
    display: none;
  }

  .desktop {
    display: none;
  }

  .mobile,
  .desktop {
    p {
      line-height: 1.5rem;
      margin: 0;
    }
  }

  a {
    color: $neutral-color-10;
    text-decoration: none;

    padding: 0.375rem;
    margin: 0.625rem;

    &:visited {
      color: inherit;
    }
  }
}

@media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
  nav {
    background-color: transparent;
    top: 0;

    height: 100%;
    width: $navigation-bar-min-width;

    flex-direction: column;
    gap: 12px;
    padding: 0.75rem;
    align-items: flex-start;
    justify-content: flex-start;

    .desktop {
      display: block;
    }

    a {
      padding: 0;
      width: 100%;
      border-radius: 18px;
      margin: 0;
      transition: background-color 0.15s ease-out;

      &:hover {
        background-color: $main-color-95;
      }

      &.router-link-active {
        background-color: $main-color-90;
      }

      p {
        span {
          &.material-symbols-rounded {
            padding: 0.375rem;
            margin: 0.625rem;

            &.filled {
              font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 48;
            }
          }

          &.title {
            display: inline;
            line-height: 3.5rem;
          }
        }
      }
    }
  }
}
</style>
