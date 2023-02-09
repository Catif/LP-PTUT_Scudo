<script setup>
import Button from './Button.vue';
import Icon from './Icon.vue';

</script>

<template>
    <Button>
        <Icon>
            <slot></slot>
        </Icon>
    </Button>
</template>

<style lang="scss" scoped>
button {
    padding: .375rem;
    margin: .625rem;
}
</style>