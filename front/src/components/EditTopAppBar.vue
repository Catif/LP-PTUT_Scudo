<script setup>
import { useRouter } from 'vue-router';
import { inject } from "vue";
import ModalBottomSheet from "@/components/ScudoTheming/ModalBottomSheet.vue";
import IconButton from "@/components/ScudoTheming/IconButton.vue";
import Icon from "@/components/ScudoTheming/Icon.vue";

const props = defineProps(["resource", "title", "mobileOnly"]);
const router = useRouter();
const bus = inject('bus')

function switchMode() {
  alert('fonction non créée')
}

function changeState() {
  bus.emit('TopAppBarModal')
}


function back() {
  router.push({ name: "resourceById", params: { id: props.resource.id } })
}

</script>



<template>
  <header>
    <section>
      <IconButton @click="back"> arrow_back </IconButton>
      <h1>Édition</h1>
    </section>
    <section>
      <IconButton>search</IconButton>
      <IconButton>account_circle</IconButton>
      <IconButton @click="changeState">more_vert</IconButton>
    </section>
  </header>
  <ModalBottomSheet bus="TopAppBarModal">
    <router-link to="create-group">
      <Icon>groups</Icon>Créer un groupe
    </router-link>
    <!-- <button @click="switchMode">
          <Icon>dark_mode</Icon>Mode nuit
        </button> -->
    <router-link to="settings">
      <Icon>settings</Icon>Paramètres
    </router-link>
  </ModalBottomSheet>
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