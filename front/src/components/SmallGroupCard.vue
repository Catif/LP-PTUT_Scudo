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
			<Image :src="props['group'].url.image" :alt="'Photo de présentation de ' + props['group'].name" />
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

img {
	aspect-ratio: 2 / 1;
}
</style>
