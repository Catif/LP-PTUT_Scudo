<template>
    <button>
        <slot></slot>
    </button>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

button {
    line-height: 2.5rem;

    font-size: 1.25rem;

    margin: .75rem;
    padding: .75rem;

    border-radius: 1.125rem;
    border: none;

    background: $main-color-40;
    color: $neutral-color-98;

    cursor: pointer;

    transition: background ease-out 150ms;
}

button:hover {
    background: $main-color-50;

    transition: none;
}

button:active {
    background: $main-color-60;
}
</style>