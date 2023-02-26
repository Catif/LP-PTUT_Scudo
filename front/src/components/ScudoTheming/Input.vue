<script setup>
import { inject } from 'vue';


const bus = inject('bus');


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
		type: [String, Number, File],
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
	small: {
		type: Boolean,
		default: false,
	},
});

function changeOK() {
	bus.emit('changeOK')
}

defineEmits(["update:value"]);
</script>

<template>
	<div v-bind:class="{ border: props.border, small: props.small }">
		<template v-if="props.label">
			<label v-bind:class="{ active: props.value.length > 0 }" :for="props.name">{{ props.label }}</label>
		</template>
		<input :type="props.type" @blur="changeOK" :id="props.name" :name="props.name" :value="props.value"
			:required="props.required" :disabled="props.disabled" :placeholder="props.placeholder"
			@input="$emit('update:value', $event.target.value)" />
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
	margin: 1.5rem 0.75rem;

	&.border {
		border: 1px solid;
		border-radius: 0.25rem;
		border-color: $light-border;
	}

	label {
		position: absolute;
		left: 0.5rem;
		color: $light-text-secondary;
		top: 50%;
		padding: 0 0.5rem;
		transform: translate(0, -50%);
		cursor: text;

		transition: all 0.1s ease-out;

		&.active {
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
				background-color: $light-bg-primary;
			}
		}
	}

	.picture {
		background-color: rgba(0, 0, 0, 0.1);
		border-radius: 0.25rem;
		margin: auto;
		margin-top: 1rem;

		width: 100px;
		height: 100px;
		object-fit: cover;
	}

	input {
		border: none;
		background-color: transparent;
		line-height: 1.5rem;
		font-size: 1rem;
		padding: 1rem;
		z-index: 2;
		width: 100%;

		&:focus {
			outline: none;
		}
	}

	&.small input {
		line-height: 1rem;
		padding: 0.375rem 0.75rem;
	}
}
</style>
