<template>
  <div>
    <slot></slot>
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

div {
  display: inline-block;

  line-height: 1.5rem;

  font-size: 1rem;
  font-weight: 500;

  margin: .75rem;
  padding: .375rem .75rem;

  border-radius: 1.125rem;

  background: $bg-alert;
  color: $text-button-alert;
}
</style>