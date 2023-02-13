<script setup>

const props = defineProps(['user'])

</script>
<template>
  <img :src="props['user'].image" :alt="'Image de ' + props['user'].username">
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

img {
  aspect-ratio: 1 / 1;
  border: 2px solid $light-border;
  border-radius: 1.125rem;
  object-fit: cover;
  vertical-align: bottom;
}

// Au lieu de src et alt c'est le user qui est passé, donc recup la src depuis le user et changer le alt pour profil de + le nom

// Mettre autour de l'image un routeur link vers la page de l'utilisateur en utilisant le username
</style>
