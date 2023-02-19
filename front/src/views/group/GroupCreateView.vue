<script setup>
// Composant
import Title from "@/components/ScudoTheming/Title.vue";
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";

// Fonction
import { ref, reactive, inject } from "vue";
import { useSessionStore } from "@/stores/session";

const sessionStore = useSessionStore();
const API = inject("API");

const form = reactive({
	name: "",
	description: "",
});

const image = reactive({});

const message = ref("");

function createGroup() {
	if (form.name == "") {
		message.value = "Vous n'avez pas rentré de nom de groupe.";
	} else if (form.name.length < 3) {
		message.value = "Le nom de votre groupe est trop court. Il doit faire au minimum 3 caratères.";
	} else if (form.description == "") {
		message.value = "Vous n'avez pas écris de description pour votre groupe.";
	} else if (form.description.length < 9) {
		message.value = "La description de votre groupe est trop courte. Elle doit faire au minimum 10 caractères";
	}

	API.post("/api/upload", {
		file: image.value,
	}).then((data) => {
		console.log(data);
		// API.post("/api/group", {
		//   name: form.name,
		//   description: form.description,
		// });
	});
}
</script>

<template>
	<MainFeed>
		<Title>Test</Title>
	</MainFeed>
</template>

<style lang="scss" scoped></style>
