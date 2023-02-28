<script setup>
// Importation de composants
import TopAppBar from "@/components/ScudoTheming/TopAppBar.vue";
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";
import ResourceCard from "@/components/ResourceCard.vue";

// Importation de méthode
import { ref, inject, onMounted } from "vue";

// Importation de store
import { useSessionStore } from "@/stores/session.js";

const API = inject("api");
const Session = useSessionStore();

const listResources = ref([]);

function getResources() {
	const config = {
		headers: {
			Authorization: Session.data.token,
		},
	};

	API.get("/api/resources?page=1&limit=20", config)
		.then((response) => {
			const data = response.data;
			data.result.resources.map((resource) => {
				loadUserForResource(resource.id_user).then((user) => {
					resource.user = user;
					listResources.value.push(resource);
				});
			});
		})
		.catch((err) => {
			console.log(err.response.data);
		});
}

function loadUserForResource(idUser) {
	let config = {
		headers: {
			Authorization: Session.data.token,
		},
	};
	return API.get(`/api/user/${idUser}`, config)
		.then((response) => {
			return response.data.result.user;
		})
		.catch((error) => {
			console.log(error);
		});
}

onMounted(() => {
	getResources();
});
</script>

<template>
	<MainFeed>
		<TopAppBar></TopAppBar>
		<ResourceCard v-for="resource in listResources" :resource="resource" :user="resource.user" />
		<!-- :group="group" -->
	</MainFeed>
</template>
