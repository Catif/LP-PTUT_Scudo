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
  background: $main-color-90;
}

div:hover {
  background: $main-color-95;
}

div:active {
  background: $main-color-98;
}
</style>