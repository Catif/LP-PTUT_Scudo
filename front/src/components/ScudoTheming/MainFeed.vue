<script setup>
const props = defineProps({
  TopAppBar: {
    type: Boolean,
    default: true,
  }
});

</script>

<template>
  <main :class="{ paddingTopToTopAppBar: TopAppBar }">
    <div id="container">
      <slot></slot>
    </div>
  </main>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

main {
  flex-grow: 1;
  padding-bottom: 3.5rem;
}

.paddingTopToTopAppBar {
  padding-top: 3.5rem;
}

#container {
  max-width: $content-min-width;
  margin: auto;
}

@media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
  main {
    padding-top: 0;
  }

  .paddingTopToTopAppBar {
    padding-top: 0rem;
  }
}
</style>
