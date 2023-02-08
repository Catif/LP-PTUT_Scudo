<template>
  <p>
    <slot></slot>
  </p>
</template>

<style lang="scss"scoped>
@import "@/assets/scss/colors";

p {
  line-height: 1rem;

  font-size: .875rem;

  margin: .75rem;

  color: $neutral-color-10;
}
</style>