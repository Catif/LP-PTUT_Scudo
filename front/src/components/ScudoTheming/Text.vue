<template>
  <p>
    <slot></slot>
  </p>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

p {
  line-height: 1.25rem;

  font-size: 1rem;

  margin: 0.75rem;

  color: $text-primary;
}
</style>
