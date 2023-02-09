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
  height: 50px;

  background-color: $main-color-95;
  border-radius: 18px;

  display: flex;
  flex-direction: row;
  align-items: center;

  span {
    margin-left: 1rem;
  }
  & > div {
    margin: 0;
  }
}
</style>
