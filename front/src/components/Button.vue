<template>
    <button>
        <slot></slot>
    </button>
</template>

<style scoped>
button {
    line-height: 1.5rem;

    font-size: 1rem;

    margin: .75rem;
    padding: .375rem .75rem;

    border-radius: 1.125rem;
    border: none;

    background: rgb(83, 83, 255);
    color: white;

    cursor: pointer;
}

button:hover {
    background: rgba(83, 83, 255, 0.85);
}

button:active {
    background: rgba(83, 83, 255, 0.7);
}
</style>