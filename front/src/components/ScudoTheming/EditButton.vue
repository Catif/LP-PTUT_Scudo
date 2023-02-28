<script setup>
import FilledButton from "@/components/ScudoTheming/FilledButton.vue";
const props = defineProps(['route'])
</script>

<template>
  <div class="followButton">
    <RouterLink :to="props.route" id="edit">
      <FilledButton>Modifier mon profil</FilledButton>
    </RouterLink>
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors.scss";

button {
  width: 100%;
}

.followButton {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  border-radius: 18px;
  overflow: hidden;
  gap: 4px;

  &>* {
    margin: 0;
    display: flex;
    justify-content: center;
  }

  #edit {
    text-decoration: none;
    flex-grow: 1;
    border-radius: 18px 0 0 18px;
    text-transform: uppercase;
    font-weight: 500;
    margin-left: 20px;
  }
}
</style>
