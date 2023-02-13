<script setup>

const props = defineProps(['user'])

</script>

<template>
  <router-link :to="'/' + props['user'].username">
    @<slot></slot>
  </router-link>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

a {
  line-height: 1rem;

  font-size: .875rem;
  text-decoration: none;

  color: $light-text-secondary;
  transition: color ease-out 150ms;
}

a:hover {
  color: $light-text-secondary-hover;

  transition: color ease-out 150ms;
}

a:active {
  color: $light-text-secondary-active;

  transition: none;
}

// passer le user au lieu du 'to', donc récup le username et non le to, et mettre le même lien que sur ProfilePicture
</style>