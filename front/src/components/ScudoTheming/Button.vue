<script setup>

const props = defineProps({
    light: {
        type: Boolean,
        default: false,
        required: false,
    },
});

</script>

<template>
    <button :class="{ light: light }">
        <slot></slot>
    </button>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

button {
    line-height: 1.5rem;

    font-size: 1rem;

    margin: .75rem;
    padding: .375rem .75rem;

    border-radius: 1.125rem;
    border: none;

    background: transparent;
    color: $light-text-primary;

    cursor: pointer;

    transition: background ease-out 150ms;

    &.light {
        color: $dark-text-primary;
    }
}

button:hover {
    background: $light-bg-primary-hover;

    transition: background ease-out 150ms;

    &.light {
        background-color: $dark-bg-primary-hover;
    }
}

button:active {
    background: $light-bg-primary-active;

    transition: none;

    &.light {
        background-color: $dark-bg-primary-active;
    }
}
</style>