<template>
    <button>
        <slot></slot>
    </button>
</template>

<style lang="scss" scoped>
@import "../assets/scss/_colors.scss";

button {
    line-height: 1.5rem;

    font-size: 1rem;

    margin: .75rem;
    padding: .375rem .75rem;

    border-radius: 1.125rem;
    border: none;

    background: $main-color-40;
    color: white;

    cursor: pointer;

    transition: background ease-out 1500ms;
}

button:hover {
    background: $main-color-50;
}

button:active {
    background: $main-color-60;
}
</style>