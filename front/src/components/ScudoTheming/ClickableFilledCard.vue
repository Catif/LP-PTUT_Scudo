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
  background: $bg-secondary;
}

div:hover {
  background: $bg-secondary-hover;
}

div:active {
  background: $bg-secondary-active;
}
</style>