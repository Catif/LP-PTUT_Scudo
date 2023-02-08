<script setup>
import Button from './Button.vue';

</script>

<template>
    <Button>
        <slot></slot>
    </Button>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

button {
    background: $main-color-40;
}

button:hover {
    background: $main-color-50;
}

button:active {
    background: $main-color-60;
}
</style>