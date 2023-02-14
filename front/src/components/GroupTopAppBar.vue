<script setup>
import TopAppBar from "@/components/ScudoTheming/TopAppBar.vue";
import ModalBottomSheet from "@/components/ScudoTheming/ModalBottomSheet.vue";
import IconButton from "./ScudoTheming/IconButton.vue";
import Icon from "./ScudoTheming/Icon.vue";

const props = defineProps(['group'])

</script>

<template>
  <TopAppBar :back="true" :title="group.name"></TopAppBar>
</template>

<style lang="scss" scoped>

</style>