<script setup>
const props = defineProps(["user"]);
</script>
<template>
	<template v-if="typeof (props['user']) != 'undefined'">
		<RouterLink :to="'/' + props['user'].username">
			<img v-if="props['user'].url.image == ''" src="/dist/userPictureDefault.png"
				:alt="'Photo de profil de ' + props['user'].username" />
			<img v-else :src="props['user'].url.image" :alt="'Photo de profil de ' + props['user'].username" />
		</RouterLink>
	</template>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

img {
	aspect-ratio: 1 / 1;
	border: 2px solid $light-border;
	border-radius: 1.125rem;
	object-fit: cover;
	vertical-align: bottom;
	width: 100%;
}
</style>
