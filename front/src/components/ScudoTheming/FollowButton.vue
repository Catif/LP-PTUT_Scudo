<script setup>
import FilledButton from "@/components/ScudoTheming/FilledButton.vue";
import Icon from "@/components/ScudoTheming/Icon.vue";

import { defineProps, inject } from "vue";
import { useSessionStore } from "@/stores/session";

const props = defineProps({
	following: {
		type: Boolean,
		required: false,
	},
	owner: {
		type: Boolean,
		required: false,
	},
	type: {
		type: String,
		required: true,
	},
	id: {
		type: String,
		required: true,
	},
});

const Session = useSessionStore();

const API = inject("api");
const bus = inject("bus");

function follow() {
	if (props.type == "group") {
		API.post(
			`/api/group/${props.id}/follow`,
			{},
			{
				headers: {
					Authorization: Session.data.token,
				},
			}
		)
			.then((response) => {
				bus.emit("messageFollow", [response.data.result.message, "success"]);
			})
			.catch((error) => {
				console.log(error);
				bus.emit("messageFollow", [error.response.data.error, "error"]);
			});
	} else if (props.type == "user") {
		API.post(
			`/api/user/${props.id}/follow`,
			{},
			{
				headers: {
					Authorization: Session.data.token,
				},
			}
		)
			.then((response) => {
				console.log(response);
			})
			.catch((error) => {
				console.log(error);
			});
	}
}
</script>

<template>
	<div class="followButton">
		<template v-if="!following && !owner">
			<FilledButton id="follow" @click="follow">Suivre</FilledButton>
		</template>
		<template v-else-if="!owner">
			<FilledButton id="unfollow">Ne plus suivre</FilledButton>
			<FilledButton id="notification"><Icon>notifications</Icon></FilledButton>
		</template>
		<template v-else>
			<RouterLink :to="{ name: 'groupEdit', params: { id: id } }" id="edit">
				<FilledButton>Modifier</FilledButton>
			</RouterLink>
		</template>
	</div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors.scss";

.followButton {
	display: flex;
	flex-direction: row;
	justify-content: space-between;
	align-items: center;
	width: 100%;
	border-radius: 18px;
	overflow: hidden;
	gap: 4px;

	& > * {
		margin: 0;
		display: flex;
		justify-content: center;
	}

	#unfollow {
		flex-grow: 1;
		border-radius: 18px 0 0 18px;
		text-transform: uppercase;
		font-weight: 500;
	}

	#follow,
	a#edit,
	a#edit button {
		flex-grow: 1;
		border-radius: 18px;
		text-transform: uppercase;
		font-weight: 500;

		text-decoration: none;
	}

	a#edit button {
		margin: 0;
	}

	#notification {
		width: 40px;
		flex-grow: 0;
		border-radius: 0 18px 18px 0;
		padding-right: 10px;
		padding-left: 6px;

		span {
			font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 48;
		}
	}
}
</style>
