<script setup>
import Card from "@/components/ScudoTheming/ClickableFilledCard.vue";
import Image from "@/components/ScudoTheming/Image.vue";
import Title from "@/components/ScudoTheming/Title.vue";
import Icon from "@/components/ScudoTheming/Icon.vue";

import { useUtils } from "@/stores/utils";
const utils = useUtils();

const props = defineProps(["group"]);
</script>

<template>
	<RouterLink :to="{ name: 'groupByID', params: { id: group.id } }">
		<Card>
			<div class="image-border">
				<Image :src="props['group'].url.image" :alt="'Photo de présentation de ' + props['group'].name" />
			</div>
			<section>
				<Title>
					{{ props["group"].name }}
				</Title>
				<Title>
					{{ utils.formatNumber(group.followers, 2) }}
					<Icon> groups </Icon>
				</Title>
			</section>
		</Card>
	</RouterLink>
</template>

<style lang="scss" scoped>
section {
	display: flex;
	justify-content: space-between;
}
div.image-border {
	border-radius: 28px;
	overflow: hidden;
	img {
		aspect-ratio: 2 / 1;
		transition: transform 0.2s;
		border-radius: 0px;
	}
}

a {
	text-decoration: none;
}

a:hover img {
	transform: scale(1.1);
}
</style>
