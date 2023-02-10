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
  color: $text-button-alert;
  background-color: $bg-button;
}

button:hover {
  background-color: $bg-button-hover;
}

button:active {
  background-color: $bg-button-active;
}
</style>
