<script setup>
import { reactive, inject } from "vue";
import IconButton from "./IconButton.vue";

const props = defineProps(["bus"]);
const bus = inject("bus");

const props = defineProps(["bus"]);
const bus = inject("bus");

var modal = reactive({
	state: false,
	temp: false,
});

bus.on(props["bus"], function () {
	modal.state = true;
});
</script>

<template>
	<button @click="modal.state = !modal.state" :class="{ overlay: true, active: modal.state }"></button>
	<div :class="{ open: modal.state, red: modal.temp }">
		<slot></slot>
	</div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries";
.red {
	background-color: red;
}
div {
	position: fixed;
	z-index: 1000;
	bottom: -100%;
	left: 50%;
	transform: translateX(-50%);

	box-sizing: border-box;
	width: 100%;
	max-width: $content-min-width;

	display: flex;
	flex-direction: column;

	padding: 0.75rem;

	border-top-left-radius: 2.375rem;
	border-top-right-radius: 2.375rem;

	background: $light-bg-primary;

	transition: bottom 200ms ease-out;

	:slotted(a),
	:slotted(button) {
		line-height: 1.5rem;

		padding: 0.75rem;

		font-size: 1rem;
		text-align: left;
		text-decoration: none;

		border: none;

		background: transparent;
		color: $light-text-primary;

		cursor: pointer;

		span {
			margin-right: 0.75rem;
		}
	}

	&.open {
		bottom: 0;
	}
}

.overlay {
	border: none;
	padding: 0;
	margin: 0;

	position: fixed;
	visibility: hidden;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: rgba(0, 0, 0, 0);
	z-index: 999;
	transition: visibility 200ms ease-out, background-color 200ms ease-out;
}

.overlay.active {
	background-color: rgba(0, 0, 0, 0.3);
	visibility: visible;
}
</style>
