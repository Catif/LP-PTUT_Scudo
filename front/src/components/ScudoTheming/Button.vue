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

    background: $dark-00;
    color: white;

    cursor: pointer;

    transition: background ease-out 150ms;
}

button:hover {
    background: $dark-10;

    transition: none;
}

button:active {
    background: $dark-20;
}
</style>