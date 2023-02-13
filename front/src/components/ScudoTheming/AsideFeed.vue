<script setup>
window.addEventListener("scroll", function () {

  var element = document.getElementById("AsideContainer");

  element.classList.remove('fixed')

  var positionY = element.offsetTop + element.offsetHeight - window.pageYOffset - this.innerHeight + 12;

  if (positionY <= 0) {
    element.classList.add('fixed')
  }

});
</script>

<template>
  <aside>
    <div id="AsideContainer">
      <div>
        <slot></slot>
      </div>
    </div>
  </aside>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

aside {
  display: none;
  width: $aside-bar-min-width;
  flex-shrink: 0;
}

.fixed {
  position: fixed;
  bottom: 0;
}

@media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $aside-bar-min-width)) {
  aside {
    display: block;
  }
}
</style>