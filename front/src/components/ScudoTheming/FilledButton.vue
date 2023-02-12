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
  color: $light-text-button-alert;
  background-color: $light-bg-button;
}

button:hover {
  background-color: $light-bg-button-hover;
}

button:active {
  background-color: $light-bg-button-active;
}
</style>
