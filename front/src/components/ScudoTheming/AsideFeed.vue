<script setup>
window.addEventListener("scroll", function () {

  var element = document.getElementById("AsideContainer");

  element.classList.remove('fixed')

  var positionY = element.offsetTop + element.offsetHeight - window.pageYOffset - this.innerHeight + 12;

  if (positionY <= 0) {
    element.classList.add('fixed')
  }

});

const props = defineProps(['large'])

</script>

<template>
  <aside :class="{ large: props.large }">
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
  flex-shrink: 0;
  width: $aside-bar-min-width;

  &.large {
    width: $content-min-width;
  }
}

.fixed {
  position: fixed;
  bottom: 0;
}

@media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $aside-bar-min-width + 24px)) {
  aside:not(.large) {
    display: block;
  }
}

@media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $content-min-width + 24px)) {
  aside.large {
    display: block;
  }
}
</style>