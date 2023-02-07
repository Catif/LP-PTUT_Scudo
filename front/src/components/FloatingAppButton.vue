<template>
    <button>
        <slot></slot>
    </button>
</template>

<style scoped>
button {
    line-height: 2.5rem;

    font-size: 1.25rem;

    margin: .75rem;
    padding: .75rem;

    border-radius: 1.125rem;
    border: none;

    background: rgb(83, 83, 255);
    color: white;

    cursor: pointer;
}
</style>