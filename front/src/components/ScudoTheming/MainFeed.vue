<template>
  <main>
    <div id="container">
      <slot></slot>
    </div>
  </main>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

main {
  flex-grow: 1;
}

#container {
  width: $content-min-width;
  margin: auto;
}
</style>