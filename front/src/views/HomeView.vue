<script setup>
// Importation de composants
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";

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

	API.get("/api/resources?page=1&limit=5", config)
		.then((response) => {
			const result = response.data;
			console.log(result);
		})
		.catch((err) => {
			console.log(err.response.data);
		});
}

onMounted(() => {
	getResources();
});
</script>

<template>
	<MainFeed>
		<h1>Test</h1>
	</MainFeed>
</template>
