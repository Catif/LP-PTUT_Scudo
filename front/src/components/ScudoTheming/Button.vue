<template>
    <button>
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
}

button:hover {
    background: $light-bg-primary-hover;

    transition: background ease-out 150ms;
}

button:active {
    background: $light-bg-primary-active;

    transition: none;
}
</style>