<script setup>
// Import ScudoTheming components
import Icon from "./ScudoTheming/Icon.vue";
import Text from "./ScudoTheming/Text.vue";
import Image from "./ScudoTheming/Image.vue";

// Import Navbar components
import Search from "./Navbar_Search.vue";

// Import Route
import { useRoute } from "vue-router";
const route = useRoute();

// Create elementsNav array
const elementsNav = [
  // Mobile + Desktop
  { name: "Home", path: "/", icon: "home", title: "Accueil", mobile: true },
  { name: "Upload", path: "/upload", icon: "add_circle", title: "Publier", mobile: true },
  { name: "Conversation", path: "/conversation", icon: "chat_bubble", title: "Conversations", mobile: true },

  // Desktop
  { name: "Profil", path: "/profile", icon: "account_circle", title: "Profil", mobile: false },
  { name: "Params", path: "/settings", icon: "settings", title: "Paramètres", mobile: false },
];
</script>

<template>
  <nav>
    <router-link to="/" id="logo">
      <Image src="/assets/img/logo-short_light.svg" alt="Logo" />
    </router-link>

    <Search id="search" />

    <router-link v-for="el in elementsNav" :key="el.name" :to="el.path"
      v-bind:class="{ mobile: el.mobile, desktop: !el.mobile }">
      <Text>
        <Icon :active="route.path == el.path">{{ el.icon }}</Icon><span class="title">{{ el.title }}</span>
      </Text>
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

  background-color: $light-bg-primary;

  .desktop,
  .title,
  #search {
    display: none;
  }

  #logo {
    display: none;

    img {
      width: 3rem;
      padding: 0.5rem;
      margin-left: 0.75rem;
      border-radius: 0;
    }
  }

  .mobile,
  .desktop {
    p {
      line-height: 1.5rem;
      margin: 0;
    }
  }

  a {
    color: $light-text-primary;
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

    .desktop,
    #logo {
      display: block;
    }

    #logo {
      width: fit-content;
      padding: 0.75rem;

      &:hover {
        background-color: transparent;
      }

      &.router-link-active {
        background-color: transparent;
      }

      margin: 2.75rem 0 0.25rem 0;
    }

    #search {
      display: flex;
    }

    a {
      padding: 0;
      width: 100%;
      border-radius: 18px;
      margin: 0;
      transition: background-color 0.15s ease-out;

      &:hover {
        background-color: $light-bg-secondary-hover;
      }

      &:active,
      &.router-link-active {
        background-color: $light-bg-secondary;
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
