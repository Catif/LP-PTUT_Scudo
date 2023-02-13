<script setup>

const props = defineProps(['src', 'alt'])

</script>
<template>
  <img :src="props['src']" :alt="props['alt']">
</template>

<style scoped>
img {
  width: 100%;
  object-fit: cover;
  border-radius: 1.75rem;
  vertical-align: bottom;
}
</style>