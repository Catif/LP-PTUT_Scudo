<script setup>
// Composant
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";
import Title from "@/components/ScudoTheming/Title.vue";
import Input from "@/components/ScudoTheming/Input.vue";
import Textarea from "@/components/ScudoTheming/Textarea.vue";
import Button from "../../components/ScudoTheming/FilledButton.vue";
import Alert from "@/components/ScudoTheming/Alert.vue";

// Fonction
import { ref, reactive, inject } from "vue";
import { useSessionStore } from "@/stores/session";
import { useRouter } from "vue-router";

const Session = useSessionStore();
const router = useRouter();

const API = inject("api");

const form = reactive({
	name: "",
	description: "",
	image: "",
});

const message = ref(null);

function createGroup() {
	message.value = "";
	if (form.name == "") {
		message.value = "Vous n'avez pas rentré de nom de groupe.";
		return;
	} else if (form.name.length < 3) {
		message.value = "Le nom de votre groupe est trop court. Il doit faire au minimum 3 caratères.";
		return;
	} else if (form.description == "") {
		message.value = "Vous n'avez pas écris de description pour votre groupe.";
		return;
	} else if (form.description.length < 9) {
		message.value = "La description de votre groupe est trop courte. Elle doit faire au minimum 10 caractères";
		return;
	}

	let fileData = new FormData();
	fileData.append("file", form.image);

	let config = {
		headers: {
			"Content-Type": "multipart/form-data",
			Authorization: Session.data.token,
		},
	};

	API.post("/api/upload", fileData, config)
		.then((response) => {
			let url = response.data.result.url;

			API.post(
				"/api/group",
				{
					name: form.name,
					description: form.description,
					image: url,
				},
				config
			)
				.then((response) => {
					router.push({ name: "groupByID", params: { id: response.data.result.group.id } });
				})
				.catch((err) => {
					message.value = err.response.data.error;
				});
		})
		.catch((err) => {
			message.value = err.response.data.error;
		});
}

// Watch value of form.image
</script>

<template>
	<MainFeed id="create-group">
		<Title>Création d'un groupe !</Title>

		<form>
			<Alert v-if="message"> {{ message }} </Alert>
			<Input type="text" name="name" label="Nom" v-model:value="form.name" />
			<Input type="file" name="image" label="Photo" v-model:value="form.image" />
			<Textarea name="description" label="Description" v-model:value="form.description" />

			<Button @click.prevent="createGroup">Créer le groupe</Button>
		</form>
	</MainFeed>
</template>

<style lang="scss" scoped>
#create-group {
	padding-top: 50px;
}
#container {
	h2 {
		text-align: center;
	}

	form {
		width: 100%;

		.border {
			margin-left: 0;
			margin-right: 0;
		}
	}

	button {
		width: 100%;
		margin-top: 0;
		margin-left: 0;
		margin-right: 0;
	}
}
</style>
