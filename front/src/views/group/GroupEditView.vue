<script setup>
// Composant
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";
import Title from "@/components/ScudoTheming/Title.vue";
import Input from "@/components/ScudoTheming/Input.vue";
import Textarea from "@/components/ScudoTheming/Textarea.vue";
import Button from "../../components/ScudoTheming/FilledButton.vue";
import Alert from "@/components/ScudoTheming/Alert.vue";
import EditGroupTopAppBar from "@/components/EditGroupTopAppBar.vue";

// Fonction
import { ref, reactive, inject, onMounted } from "vue";
import { useSessionStore } from "@/stores/session";
import { useRoute, useRouter } from "vue-router";

const Session = useSessionStore();
const router = useRouter();
const route = useRoute();

const bus = inject("bus");
const API = inject("api");

const form = reactive({
	name: "",
	description: "",
	image: "",
});

const group = ref(null);

const message = ref(null);

function loadGroup() {
	API.get(`/api/group/${route.params.id}`, {
		headers: {
			Authorization: Session.data.token,
		},
	})
		.then((response) => {
			const result = response.data.result;

			group.value = result.group;

			if (!result.owner) {
				router.push({ name: "groupByID", params: { id: group.value.id } });
			}

			form.name = result.group.name;
			form.description = result.group.description;
			form.image = result.group.url.image;

			bus.emit("loadImage", result.group.url.image);
		})
		.catch((err) => {
			message.value = err.response.data.error;
		});
}

function editGroup() {
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

	let config = {
		headers: {
			"Content-Type": "multipart/form-data",
			Authorization: Session.data.token,
		},
	};

	if (form.image instanceof File) {
		let fileData = new FormData();
		fileData.append("file", form.image);

		API.post("/api/upload", fileData, config)
			.then((response) => {
				let url = response.data.result.url;

				API.post(
					`/api/group/${group.value.id}`,
					{
						name: form.name,
						description: form.description,
						image: url,
					},
					config
				)
					.then((response) => {
						router.push({ name: "groupByID", params: { id: group.value.id } });
					})
					.catch((err) => {
						message.value = err.response.data.error;
					});
			})
			.catch((err) => {
				message.value = err.response.data.error;
			});
	} else {
		API.post(
			`/api/group/${group.value.id}`,
			{
				name: form.name,
				description: form.description,
			},
			config
		)
			.then((response) => {
				router.push({ name: "groupByID", params: { id: group.value.id } });
			})
			.catch((err) => {
				message.value = err.response.data.error;
			});
	}
}

onMounted(() => {
	loadGroup();
});
</script>

<template>
	<MainFeed id="edit-group">
		<EditGroupTopAppBar/>
		<Title>{{ form.name }}</Title>

		<form>
			<Alert v-if="message"> {{ message }} </Alert>
			<Input type="text" name="name" label="Nom" v-model:value="form.name" />
			<Input type="file" name="image" label="Photo" v-model:value="form.image" />
			<Textarea name="description" label="Description" v-model:value="form.description" />

			<Button @click.prevent="editGroup">Modifier</Button>
		</form>
	</MainFeed>
</template>

<style lang="scss" scoped>
#edit-group {
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
