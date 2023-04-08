<script setup>
import { reactive, inject } from 'vue';
import TopAppBar from "@/components/ScudoTheming/TopAppBar.vue";
import ModalBottomSheet from "@/components/ScudoTheming/ModalBottomSheet.vue";
import IconButton from "./ScudoTheming/IconButton.vue";
import Icon from "./ScudoTheming/Icon.vue";

const props = defineProps(['back', 'title'])
const bus = inject('bus')
function switchMode() {
  alert('fonction non créée')
}

function changeState() {
  bus.emit('TopAppBarModal')
}

</script>

<template>
  <TopAppBar :back="back" :title="title" :mobileOnly="true">
    <IconButton>search</IconButton>
    <IconButton>account_circle</IconButton>
    <IconButton @click="changeState">more_vert</IconButton>
  </TopAppBar>
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

<style lang="scss" scoped></style>