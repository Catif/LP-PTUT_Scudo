<script setup>
import IconButton from "./IconButton.vue";

const props = defineProps(["back", "title", "mobileOnly"]);
</script>
<template>
  <header :class="{ backless: !props['back'] }">
    <section>
      <IconButton v-if="props['back']" @click="$router.back"> arrow_back </IconButton>
      <h1>{{ title }}</h1>
    </section>
    <section :class="{mobileOnly: props['mobileOnly']}">
      <slot></slot>
    </section>
  </header>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries";

header {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  width: 100%;
  display: flex;

  background-color: $light-bg-primary;
  border-bottom: 1px solid $light-border;

  &.backless {
    padding-left: 0.75rem;
  }
}

section {
  display: flex;

  &:last-child {
    flex-grow: 1;
    justify-content: end;
  }
}

h1 {
  line-height: 3.5rem;

  font-size: 1.25rem;
  font-weight: 400;

  margin: 0;
}

@media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
  header {
    position: static;
    border-bottom: none;
  }
  .mobileOnly{
    display: none;
  }
}
</style>
