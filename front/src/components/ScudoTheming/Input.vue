<script setup>
const props = defineProps({
  placeholder: String,
  label: String,
  disabled: {
    type: Boolean,
    default: false,
  },
  type: {
    type: String,
    default: "text",
  },
  value: String,
  required: {
    type: Boolean,
    default: false,
  },
  border: {
    type: Boolean,
    default: true,
  },
});

const inputValue = ref(props.value);
</script>

<template>
  <div v-bind:class="{ border: props.border }">
    <template v-if="props.placeholder">
      <label v-bind:class="{ active: () }">{{ props.placeholder }}</label>
    </template>
    <label>{{ props.placeholder }}</label>
    <input :type="props.type" :value="props.value" :required="props.required" :disabled="props.disabled" placeholder="test" v-model="" />
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

div {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;

  position: relative;
  margin: 1.25rem 0;

  &.border {
    border: 1px solid $neutral-color-90;
    border-radius: 0.25rem;
  }

  label {
    position: absolute;
    left: 1rem;
    color: $neutral-color-50;
    z-index: 2;

    &.active {
      color: $main-color-50;
    }
  }
  input {
    border: none;
    background-color: transparent;
    font-size: 1rem;
    padding: 1rem;
    z-index: 3;
  }
}
</style>
