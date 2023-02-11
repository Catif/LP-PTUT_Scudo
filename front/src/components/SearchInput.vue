<script setup>
import Input from "./ScudoTheming/Input.vue";
import Icon from "./ScudoTheming/Icon.vue";

import { ref } from "vue";

const searchElement = ref("");
</script>

<template>
  <form class="search">
    <Icon>search</Icon>
    <Input name="search" placeholder="Rechercher" v-model:value="searchElement" :border="false" />
  </form>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

.search {
  width: 100%;

  background-color: $main-color-95;
  border-radius: 18px;

  line-height: 1.5rem;

  span {
    margin: 1rem;
    margin-right: 0;
  }

  &>div {
    margin: 0;
    width: 100%;
  }
}
</style>
