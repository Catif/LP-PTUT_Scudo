<template>
  <aside>
    <div id="container">
      <slot></slot>
    </div>
  </aside>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

aside {
  display: none;
  width: $aside-bar-min-width;
  flex-shrink: 0;

  &>div {
    position: sticky;
    // top: 0;
  }
}

@media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $aside-bar-min-width)) {
  aside {
    display: block;
  }
}
</style>