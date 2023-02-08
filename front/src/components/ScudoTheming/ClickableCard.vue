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

div:hover {
  background: $neutral-color-95;
}

div:active {
  background: $neutral-color-90;
}
</style>