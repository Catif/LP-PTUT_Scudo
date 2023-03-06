<template>
    <div>
        <slot></slot>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries";


div {
    border-top-left-radius: 2.375rem;
    border-top-right-radius: 2.375rem;
    ;
    background: $light-bg-primary;
    position: relative;
    z-index: 1000;
    margin-top: calc(100vh - 200px);
}



@media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $content-min-width + 24px)) {
    div {
        display: none;
    }
}
</style>