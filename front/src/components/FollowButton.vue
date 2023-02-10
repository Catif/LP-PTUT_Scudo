<script setup>
import IconButton from "@/components/ScudoTheming/IconButton.vue";
import Button from "@/components/ScudoTheming/Button.vue";
</script>

<template>
  <div class="followButton">
    <Button id="follow">Suivre</Button>
    <IconButton id="notification">notifications</IconButton>
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors.scss";

.followButton {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 210px;
  border-radius: 18px;
  overflow: hidden;
  gap: 4px;

  & > * {
    margin: 0;
    background-color: $main-color-80;
    color: $neutral-color-98;
    display: flex;
    justify-content: center;
  }

  #follow {
    flex-grow: 1;
    border-radius: 18px 0 0 18px;
    text-transform: uppercase;
    font-weight: 500;
  }

  #notification {
    width: 40px;
    flex-grow: 0;
    border-radius: 0 18px 18px 0;
    padding-right: 10px;

    //  Impossibilité de modifiier la weight de l'icone
    //  span {
    //    font-variation-settings: "FILL" 0, "wght" 700, "GRAD" 0, "opsz" 48;
    //  }
  }
}
</style>
