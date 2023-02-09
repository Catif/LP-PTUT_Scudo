<script setup>
import Input from "./ScudoTheming/Input.vue";

const props = defineProps(["placeholder"]);
</script>

<template>
  <form class="search">
    <Input :placeholder="props.placeholder" label="Ma recherche" />
    <Input :placeholder="props.placeholder" label="Ma recherche" />
    <Input :placeholder="props.placeholder" label="Ma recherche" />
  </form>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

.search {
  // background-color: $main-color-95;
}
</style>
