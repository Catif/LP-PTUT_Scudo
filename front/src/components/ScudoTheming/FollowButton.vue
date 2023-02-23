<script setup>
import FilledButton from "@/components/ScudoTheming/FilledButton.vue";
import Icon from "@/components/ScudoTheming/Icon.vue";

import { ref, defineProps, inject } from "vue";
import { useSessionStore } from "@/stores/session";

const props = defineProps({
	following: {
		type: Boolean,
		default: false,
	},
	owner: {
		type: Boolean,
		default: false,
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
				bus.emit("actionFollow", [response.data.result.message, "success"]);
			})
			.catch((error) => {
				console.log(error);
				bus.emit("actionFollow", [error.response.data.error, "error"]);
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
				bus.emit("actionFollow", [response.data.result.message, "success"]);
			})
			.catch((error) => {
				console.log(error);
				bus.emit("actionFollow", [error.response.data.error, "error"]);
			});
	}
}

function unfollow() {
	if (props.type == "group") {
		API.delete(`/api/group/${props.id}/unfollow`, {
			headers: {
				Authorization: Session.data.token,
			},
		})
			.then((response) => {
				bus.emit("actionFollow", [response.data.result.message, "success"]);
			})
			.catch((error) => {
				console.log(error);
				bus.emit("actionFollow", [error.response.data.error, "error"]);
			});
	} else if (props.type == "user") {
		API.delete(`/api/user/${props.id}/unfollow`, {
			headers: {
				Authorization: Session.data.token,
			},
		})
			.then((response) => {
				bus.emit("actionFollow", [response.data.result.message, "success"]);
			})
			.catch((error) => {
				console.log(error);
				bus.emit("actionFollow", [error.response.data.error, "error"]);
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
			<FilledButton id="unfollow" @click="unfollow">Ne plus suivre</FilledButton>
			<FilledButton id="notification"><Icon>notifications</Icon></FilledButton>
		</template>
		<template v-else>
			<template v-if="type == 'group'">
				<RouterLink :to="{ name: 'groupEdit', params: { id: id } }" id="edit">
					<FilledButton>Modifier</FilledButton>
				</RouterLink>
			</template>
			<template v-else-if="type == 'user'">
				<RouterLink :to="{ name: 'userEdit', params: { id: id } }" id="edit">
					<FilledButton>Modifier</FilledButton>
				</RouterLink>
			</template>
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
