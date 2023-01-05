<script setup>
import TopAppBar from "@/components/ScudoTheming/TopAppBar.vue";
import ModalBottomSheet from "@/components/ScudoTheming/ModalBottomSheet.vue";
import Icon from "./ScudoTheming/Icon.vue";
import Search from "./SearchInput.vue";

function switchMode() {
  alert('fonction non créée')
}

</script>

<template>
  <TopAppBar :back="true">
    <Search id="search" :small="true" />
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