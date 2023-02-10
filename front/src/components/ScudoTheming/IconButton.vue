<script setup>
import Button from "./Button.vue";
import Icon from "./Icon.vue";

const props = defineProps({
  active: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <Button>
    <Icon :active="props.active">
      <slot></slot>
    </Icon>
  </Button>
</template>

<style lang="scss" scoped>
button {
  padding: 0.375rem;
  margin: 0.625rem;
}
</style>
