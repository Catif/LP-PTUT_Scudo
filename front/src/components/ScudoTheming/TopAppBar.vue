<script setup>
import IconButton from "./IconButton.vue";

const props = defineProps(["back", "title"]);
</script>
<template>
  <header :class="{ backless: !props['back'] }">
    <section>
      <IconButton v-if="props['back']" @click="$router.back"> arrow_back </IconButton>
      <h1>{{ title }}</h1>
    </section>
    <section>
      <slot></slot>
    </section>
  </header>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries";

header {
  display: flex;

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
    border-bottom: none;
  }
}
</style>
