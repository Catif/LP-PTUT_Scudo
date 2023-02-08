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
    color: white;

    cursor: pointer;

    transition: background ease-out 150ms;
}

button:hover {
    background: $neutral-color-95;

    transition: none;
}

button:active {
    background: $neutral-color-90;
}
</style>