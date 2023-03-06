<template>
    <div>
        <slot></slot>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

div {
    border-top-left-radius: 2.375rem;
    border-top-right-radius: 2.375rem;
    ;
    background: $light-bg-primary;
    position: relative;
    z-index: 1000;
    margin-top: calc(100vh - 200px);
}
</style>