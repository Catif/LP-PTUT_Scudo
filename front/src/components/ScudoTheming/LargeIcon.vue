<script setup>

const props = defineProps(['active'])

</script>
<template>
  <span v-bind:class="{ 'material-symbols-rounded': true, filled: props['active'] }">
    <slot></slot>
  </span>
</template>

<style scoped>
span {
  line-height: inherit;

  vertical-align: bottom;
  font-size: 2.5rem;
  font-variation-settings:
    'FILL' 0,
    'wght' 400,
    'GRAD' 0,
    'opsz' 48;
}

span.filled {
  font-variation-settings:
    'FILL' 1;
}
</style>