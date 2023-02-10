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

  color: $text-secondary;
  transition: color ease-out 150ms;
}

a:hover {
  color: $text-secondary-hover;

  transition: color ease-out 150ms;
}

a:active {
  color: $text-secondary-active;

  transition: none;
}
</style>