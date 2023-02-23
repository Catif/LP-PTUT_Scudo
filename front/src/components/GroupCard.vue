<script setup>
import Card from "./ScudoTheming/Card.vue";
import UserStat from "./UserStat.vue";
import FollowButton from "./ScudoTheming/FollowButton.vue";
import Text from "./ScudoTheming/Text.vue";
import Image from "./ScudoTheming/Image.vue";
import Alert from "./ScudoTheming/Alert.vue";

import { reactive, inject } from "vue";

const props = defineProps({
	group: {
		type: Object,
		required: true,
	},
});
</script>

<template>
	<Card>
		<Image :src="group.image" :alt="'Photo de couverture de' + props['group'].name" />
		<aside>
			<div class="stats">
				<UserStat :number="group.followers" type="followers" />
			</div>
			<FollowButton type="group" :id="group.id" :following="group.following" :owner="group.owner" />
		</aside>
		<Text class="biography">{{ group.description }}</Text>
	</Card>
</template>

<style lang="scss" scoped>
img {
	aspect-ratio: 2 / 1;
}

aside {
	margin-top: 0.75rem;
	display: flex;

	.stats {
		padding: 0 1.5rem;
	}
}
</style>
