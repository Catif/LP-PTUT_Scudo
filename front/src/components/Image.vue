<script setup>

const props = defineProps(['src', 'alt'])

</script>
<template>
  <img :src="props['src']" :alt="props['alt']">
</template>

<style scoped>
img {
  vertical-align: bottom;
}
</style>