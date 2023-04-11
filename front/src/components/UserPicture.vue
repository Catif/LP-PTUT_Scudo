<script setup>
const props = defineProps(["user"]);

// console.log(props.user);
</script>
<template>
  <RouterLink v-if="user" :to="'/profile/' + user.id">
    <img :src="user.url.image" :alt="'Photo de profil de ' + user.username" />
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
