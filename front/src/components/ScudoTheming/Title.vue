<template>
  <h2>
    <slot></slot>
  </h2>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

h2 {
  font-size: 1.25rem;

  margin: .75rem;

  color: $neutral-color-10;
}
</style>