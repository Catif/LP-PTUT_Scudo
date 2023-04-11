<script setup>
import Image from "@/components/ScudoTheming/Image.vue";
import Alert from "@/components/ScudoTheming/Alert.vue";
import Icon from "@/components/ScudoTheming/Icon.vue";

const props = defineProps(["resource", "user"]);

var alt = "";
if (props["resource"].type === "stream") {
  alt = "Live de " + props["user"].username;
} else {
  alt = "Vidéo de " + props["user"].username;
}
</script>

<template>
  <div class="resourceSection">
    <Alert v-if="props['resource'].type === 'stream'">LIVE</Alert>
    <div class="play">
      <Icon>play_circle</Icon>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors.scss";
.resourceSection {
  position: relative;
  z-index: 1;

  div {
    position: absolute;
    top: 0;
    left: 0;
  }

  .play {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 20rem;
    background-color: hsla(0, 0%, 0%, 0.2);
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;

    span {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 5rem;
      color: $light-bg-button;

      &:hover {
        color: $light-bg-button-hover;
      }

      &:active {
        color: $light-bg-button-active;
      }
    }
  }
}
</style>
