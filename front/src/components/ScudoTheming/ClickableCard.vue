<script  setup>
import Card from "./ClickableCard.vue";

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
  background: $light-bg-primary-hover;

  transition: background ease-out 150ms;
}

div:active {
  background: $light-bg-primary-active;

  transition: none;
}
</style>