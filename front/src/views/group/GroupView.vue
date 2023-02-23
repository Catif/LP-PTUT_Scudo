<script setup>
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";
import GroupCard from "@/components/GroupCard.vue";
import GroupTopAppBar from "@/components/GroupTopAppBar.vue";
import Alert from "@/components/ScudoTheming/Alert.vue";

import { reactive, inject, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useSessionStore } from "@/stores/session";

const route = useRoute();
const Session = useSessionStore();

const API = inject("api");
const bus = inject("bus");

const group = reactive({
	id: route.params.id,
	name: "Chargement...",
	description: "Chargement...",
	image: "https://media.tenor.com/5Bg1bLVpl8cAAAAC/loading-chargement.gif",
	followers: 0,
	following: false,
	owner: false,
});

function loadGroup() {
	let config = {
		headers: {
			"Content-Type": "multipart/form-data",
			Authorization: Session.data.token,
		},
	};
	API.get(`/api/group/${route.params.id}`, config)
		.then((response) => {
			const result = response.data.result;

			group.id = result.group.id;
			group.name = result.group.name;
			group.description = result.group.description;
			group.image = result.group.url.image;
			group.followers = result.followers;
			group.following = result.following;
			group.owner = result.owner;
		})
		.catch((error) => {
			console.log(error);
		});
}

const message = reactive({
	content: "",
	type: "",
});

bus.on("actionFollow", (event) => {
	message.type = event[1];
	if (message.type == "success") {
		group.following = !group.following;

		if (group.following) {
			group.followers++;
		} else {
			group.followers--;
		}
	} else if (message.type == "error") {
		message.content = event[0];
		console.log("group.following: " + group.following);
	}

	setTimeout(() => {
		message.content = "";
	}, 3000);
});

onMounted(() => {
	loadGroup();
});
</script>

<template>
	<MainFeed>
		<GroupTopAppBar :group="group" />
		<Alert class="alert" v-if="message.content" :type="message.type">{{ message.content }}</Alert>
		<GroupCard id="groupCard" :group="group" />

		<div id="list-resources"></div>
	</MainFeed>
</template>

<style lang="scss" scoped>
.alert {
	width: 100%;
	text-align: center;
	margin: 0;
}
</style>
