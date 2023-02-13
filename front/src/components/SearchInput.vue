<script setup>
import Input from "./ScudoTheming/Input.vue";
import Icon from "./ScudoTheming/Icon.vue";

import { ref } from "vue";


const props = defineProps({
  small: {
    type: Boolean,
    default: false,
  }
});

const searchElement = ref("");
</script>

<template>
  <form :class="{ search: true, small: small }">
    <Icon>search</Icon>
    <Input name="search" placeholder="Rechercher" v-model:value="searchElement" :border="false" :small="small" />
  </form>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

.search {
  display: flex;

  width: 100%;

  background-color: $light-bg-secondary-hover;
  border-radius: 18px;

  line-height: 1.5rem;

  &.small {
    background-color: $light-bg-secondary-hover;
    margin: 0.625rem 0;
  }

  span {
    margin: 1rem;
    margin-right: 0;
  }

  &.small span {
    margin: .375rem 0 .375rem .75rem;
  }

  &>div {
    margin: 0;
    width: 100%;
  }
}
</style>
