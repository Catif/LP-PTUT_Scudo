<script setup>
// Import ScudoTheming components
import Icon from "./ScudoTheming/Icon.vue";
import Text from "./ScudoTheming/Text.vue";
import Image from "./ScudoTheming/Image.vue";
import ModalBottomSheet from "./ScudoTheming/ModalBottomSheet.vue";

// Import Navbar components
import Search from "./SearchInput.vue";

// Import Route
import { useRoute } from "vue-router";
import { ref, inject } from "vue";
import IconButton from "./ScudoTheming/IconButton.vue";
import { useSessionStore } from '@/stores/session.js';
const route = useRoute();
const Session = useSessionStore();

// Create elementsNav array
const elementsNav = [
  // Mobile + Desktop
  // { name: "Home", path: "/", icon: "home", title: "Accueil", mobile: true },
  // { name: "Upload", path: "/upload", icon: "add_circle", title: "Publier", mobile: true },
  { name: "Conversation", path: "/conversation", icon: "chat_bubble", title: "Conversations", mobile: true },

  // Desktop
  { name: "Profil", path: `/profile/${Session.data.idUser}`, icon: "account_circle", title: "Profil", mobile: false },
  { name: "Params", path: "/settings", icon: "settings", title: "Paramètres", mobile: false },
];

const publishOpen = ref(false);
const bus = inject('bus');

function togglePublish() {
  publishOpen.value = !publishOpen.value;
}

function closePublish() {
  publishOpen.value = false;
}

function changeState() {
  bus.emit('NavBarModal')
}
</script>

<template>
  <nav>
    <router-link to="/" id="logo" @click="closePublish">
      <Image src="/assets/img/logo-short_dark.svg" alt="Logo" />
    </router-link>

    <Search id="search" @click="closePublish" />

    <!-- ACCUEIL -->
    <router-link key="Home" to="/" class="mobile" @click="closePublish">
      <Text>
        <Icon :active="route.path == '/'">home</Icon><span class="title">Accueil</span>
      </Text>
    </router-link>


    <!-- BOUTON PUBLIER -->
    <Text class="add mobile">
      <IconButton @click="changeState">add_circle</IconButton>
      <!-- <span class="title">Publier</span> -->
    </Text>
    <button :class="{ add: true, desktop: true, open: publishOpen }" @click="togglePublish">
      <Text>
        <Icon>add_circle</Icon>
        <span class="title">Publier</span>
      </Text>
      <div class="sousmenu">
        <router-link key="Film" to="/start-video/private" class="desktop">
          <Text>
            <Icon>videocam</Icon><span class="title">Filmer pour
              moi</span>
          </Text>
        </router-link>
        <router-link key="FilmAndPublish" to="/start-video/public" class="desktop">
          <Text>
            <Icon>cell_tower</Icon><span class="title">Filmer &
              Diffuser</span>
          </Text>
        </router-link>
        <router-link key="Upload" to="/upload" class="desktop">
          <Text>
            <Icon>upload</Icon><span class="title">Mettre en ligne une vidéo</span>
          </Text>
        </router-link>
      </div>
    </button>

    <!-- AUTRES BOUTONS -->
    <router-link v-for="el in elementsNav" :key="el.name" :to="el.path"
      v-bind:class="{ mobile: el.mobile, desktop: !el.mobile }" @click="closePublish">
      <Text>
        <Icon :active="route.path == el.path">{{ el.icon }}</Icon><span class="title">{{ el.title }}</span>
      </Text>
    </router-link>
  </nav>
  <ModalBottomSheet bus="NavBarModal">
    <router-link to="/start-video/private">
      <Icon>videocam</Icon>Filmer pour moi
    </router-link>
    <router-link to="/start-video/public">
      <Icon>cell_tower</Icon>Filmer & Diffuser
    </router-link><router-link to="/upload">
      <Icon>upload</Icon>Mettre en ligne une vidéo
    </router-link>
  </ModalBottomSheet>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries.scss";

nav {
  position: fixed;
  bottom: 0;
  left: 0;
  z-index: 100;

  width: 100%;

  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;

  background-color: $light-bg-primary;

  border-top: 1px solid $light-border;

  overflow: auto;

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
      text-align: start;
    }

    background-color: transparent;
    border: none;
  }

  .add {
    height: 3.5rem;
    overflow: hidden;

    transition: height 150ms ease-out, border-radius 150ms ease-out;

    &.open {
      height: 12.5rem;
    }

    &.mobile {
      margin: 0;
    }

    &.desktop {
      display: none;
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

  .sousmenu {
    display: flex;
    flex-direction: column;
    gap: .75rem;
    padding-bottom: .75rem;

    a {
      margin: 0 .75rem;
      width: auto;

      padding: 0 .375rem;

      .material-symbols-rounded {
        margin: 0;
      }

      &:last-child {
        margin-bottom: .75rem;
      }
    }
  }
}

@media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
  nav {
    position: sticky;
    top: 0;
    flex-shrink: 0;
    background-color: transparent;
    border-top: none;

    height: 100vh;
    width: $navigation-bar-min-width;

    flex-direction: column;
    gap: 12px;
    padding: 0.75rem;
    align-items: flex-start;
    justify-content: flex-start;

    .add {

      &.mobile {
        display: none;
      }

      &.desktop {
        display: block;
      }
    }

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

    a,
    button {
      padding: 0;
      width: 100%;
      border-radius: 18px;
      margin: 0;
      transition: background-color 0.15s ease-out;

      &:hover,
      &.add.open {
        background-color: $light-bg-secondary-hover;
      }

      &.add.open {
        border-radius: 1.75rem;
      }

      &:active,
      &.router-link-active {
        background-color: $light-bg-secondary;
      }

      .sousmenu {
        .title {
          line-height: 2.25rem;
        }
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
