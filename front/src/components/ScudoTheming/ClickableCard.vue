<script  setup>
import Card from "./Card.vue";

</script>

<template>
  <Card>
    <slot></slot>
  </Card>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

div {
  cursor: pointer;

  transition: background ease-out 150ms;
}

div:hover {
  background: $neutral-color-95;

  transition: none;
}

div:active {
  background: $neutral-color-90;
}
</style>