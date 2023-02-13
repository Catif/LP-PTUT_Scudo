<script setup>
import FilledButton from "@/components/ScudoTheming/FilledButton.vue";
import Icon from "@/components/ScudoTheming/Icon.vue";
</script>

<template>
  <div class="followButton">
    <FilledButton id="follow">Suivre</FilledButton>
    <FilledButton id="notification"><Icon>notifications</Icon></FilledButton>
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

  & > * {
    margin: 0;
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
    padding-left: 6px;

    span {
      font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 48;
    }
  }
}
</style>
