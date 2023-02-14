<script setup>
import TopAppBar from "@/components/ScudoTheming/TopAppBar.vue";
import ModalBottomSheet from "@/components/ScudoTheming/ModalBottomSheet.vue";
import IconButton from "./ScudoTheming/IconButton.vue";
import Icon from "./ScudoTheming/Icon.vue";

const props = defineProps(['back', 'title'])

function switchMode() {
  alert('fonction non créée')
}

</script>

<template>
  <TopAppBar :back="back" :title="title">
    <IconButton>search</IconButton>
    <IconButton>account_circle</IconButton>
    <ModalBottomSheet icon="more_vert">
      <router-link to="create-group">
        <Icon>groups</Icon>Créer un groupe
      </router-link>
      <button @click="switchMode">
        <Icon>dark_mode</Icon>Mode nuit
      </button>
      <router-link to="settings">
        <Icon>settings</Icon>Paramètres
      </router-link>
    </ModalBottomSheet>
  </TopAppBar>
</template>

<style lang="scss" scoped>

</style>