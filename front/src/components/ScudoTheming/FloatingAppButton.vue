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

    background: $bg-button;
    color: $text-button-alert;

    cursor: pointer;

    transition: background ease-out 150ms;
}

button:hover {
    background: $bg-button-hover;

    transition: none;
}

button:active {
    background: $bg-button-active;
}
</style>