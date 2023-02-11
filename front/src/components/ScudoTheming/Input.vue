<script setup>
const props = defineProps({
  placeholder: {
    type: String,
    default: "",
  },
  label: {
    type: String,
    default: "",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  type: {
    type: String,
    default: "text",
  },
  name: {
    type: String,
    default: "default",
  },
  value: {
    type: String,
    default: "",
  },
  required: {
    type: Boolean,
    default: false,
  },
  border: {
    type: Boolean,
    default: true,
  },
});

defineEmits(["update:value"]);
</script>

<template>
  <div v-bind:class="{ border: props.border }">
    <template v-if="props.label">
      <label v-bind:class="{ active: props.value.length > 0 }" :for="props.name">{{ props.label }}</label>
    </template>
    <input :type="props.type" :id="props.name" :name="props.name" :value="props.value" :required="props.required"
      :disabled="props.disabled" :placeholder="props.placeholder" @input="$emit('update:value', $event.target.value)" />
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
    left: 0.5rem;
    color: $neutral-color-50;
    top: 50%;
    padding: 0 0.5rem;
    transform: translate(0, -50%);
    cursor: text;

    transition: all 0.1s ease-out;

    &.active {
      color: $neutral-color-10;
      top: 0px;
      left: 6px;
      font-size: 0.9rem;

      &::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background-color: $neutral-color-98;
      }
    }
  }

  input {
    border: none;
    background-color: transparent;
    line-height: 1.5rem;
    font-size: 1rem;
    padding: 1rem;

    width: 100%;

    &:focus {
      outline: none;
    }
  }
}
</style>
