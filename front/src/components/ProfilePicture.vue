<script setup>

const props = defineProps(['src', 'alt'])

</script>
<template>
  <img :src="props['src']" :alt="props['alt']">
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

img {
  aspect-ratio: 1 / 1;
  border: 1.75px solid $border;
  border-radius: 1.125rem;
  object-fit: cover;
  vertical-align: bottom;
}
</style>