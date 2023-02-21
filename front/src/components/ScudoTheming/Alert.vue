<script setup>
const props = defineProps({
	type: {
		type: String,
		default: "error",
	},
});
</script>

<template>
	<div class="alert" :class="{ error: type == 'error', success: type == 'success' }">
		<slot></slot>
	</div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

div {
	display: inline-block;

	line-height: 1.5rem;

	font-size: 1rem;
	font-weight: 500;

	margin: 0.75rem;
	padding: 0.375rem 0.75rem;

	border-radius: 1.125rem;
	color: $light-text-button-alert;
}

.alert.error {
	background: $light-bg-alert;
}

.alert.success {
	background: green;
}
</style>
