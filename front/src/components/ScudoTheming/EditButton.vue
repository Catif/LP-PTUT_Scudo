<script setup>
import FilledButton from "@/components/ScudoTheming/FilledButton.vue";
</script>

<template>
  <div class="followButton">
    <FilledButton id="edit">Modifier mon profil</FilledButton>
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors.scss";

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
    flex-grow: 1;
    border-radius: 18px 0 0 18px;
    text-transform: uppercase;
    font-weight: 500;
    margin-left: 20px;
  }
}
</style>
