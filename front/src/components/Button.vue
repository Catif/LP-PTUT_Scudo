<template>
    <button>
        <slot></slot>
    </button>
</template>

<style scoped>
button {
    line-height: 1.5rem;

    font-size: 1rem;
    font-weight: 600;

    margin: .75rem;
    padding: .375rem .75rem;

    border-radius: 1.125rem;
    border: none;

    background: rgb(83, 83, 255);
    color: white;
}
</style>