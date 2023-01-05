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
  background: $light-bg-secondary;
}

div:hover {
  background: $light-bg-secondary-hover;
}

div:active {
  background: $light-bg-secondary-active;
}
</style>