<script setup>

const props = defineProps(['user'])

</script>
<template>
  <RouterLink :to="'/' + props['user'].username">
    <img :src="props['user'].image" :alt="'Photo de profil de ' + props['user'].username">
  </RouterLink>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

img {
  aspect-ratio: 1 / 1;
  border: 2px solid $light-border;
  border-radius: 1.125rem;
  object-fit: cover;
  vertical-align: bottom;
  width: 100%;
}
</style>
