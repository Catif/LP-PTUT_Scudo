<script setup>
const props = defineProps({
  number: {
    type: Number,
    required: "",
  },
  type: {
    type: String,
    required: "",
  },
});
</script>

<template>
  <div>
    <span class="number">{{ props.number }}</span>
    <span class="type">{{ props.type }}</span>
  </div>
</template>

<style lang="scss" scoped>
div {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 2px;

  .number {
    font-size: 1.25rem;
    line-height: 1.25rem;
  }

  .type {
    font-size: 0.875rem;
    line-height: 0.875rem;
  }
}
</style>
