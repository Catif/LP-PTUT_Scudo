<script setup>

</script>

<template>
  <router-link to="oui">
    @<slot></slot>
  </router-link>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

a {
  line-height: 1.25rem;

  font-size: 1rem;
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