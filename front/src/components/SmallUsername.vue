<script setup>

const props = defineProps(['to'])

</script>

<template>
  <router-link :to="props['to']">
    @<slot></slot>
  </router-link>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

a {
  line-height: 1rem;

  font-size: .875rem;
  text-decoration: none;

  color: $neutral-color-40;
  transition: color ease-out 150ms;
}

a:hover {
  color: $neutral-color-50;

  transition: color ease-out 150ms;
}

a:active {
  color: $neutral-color-60;

  transition: none;
}
</style>