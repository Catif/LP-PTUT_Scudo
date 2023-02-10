<script setup>
import Button from "./Button.vue";
</script>

<template>
  <Button>
    <slot></slot>
  </Button>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

button {
  color: $neutral-color-98;
  background-color: $main-color-40;
}

button:hover {
  background-color: $main-color-50;
}

button:active {
  background-color: $main-color-60;
}
</style>
