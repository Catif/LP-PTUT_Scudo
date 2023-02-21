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

const bus = inject("bus");

const message = reactive({
	content: "",
	type: "",
});

bus.on("messageFollow", (event) => {
	message.content = event[0];
	message.type = event[1];

	setTimeout(() => {
		message.content = "";
	}, 3000);
});
</script>

<template>
	<Alert class="alert" v-if="message.content" :type="message.type">{{ message.content }}</Alert>
	<Card>
		<Image :src="group.image" :alt="'Photo de couverture de' + props['group'].name" />
		<aside>
			<div class="stats">
				<UserStat :number="group.followers" type="followers" />
			</div>
			<FollowButton type="group" :id="group.id" />
		</aside>
		<Text class="biography">{{ group.description }}</Text>
	</Card>
</template>

<style lang="scss" scoped>
.alert {
	width: 100%;
	text-align: center;
	margin: 0;
}

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
