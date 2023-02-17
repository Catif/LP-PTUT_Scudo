<script setup>
import { reactive, ref, inject } from 'vue';
import Title from '../components/ScudoTheming/Title.vue';
import Text from '../components/ScudoTheming/Text.vue';
import Input from '../components/ScudoTheming/Input.vue';
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import Button from '../components/ScudoTheming/FilledButton.vue';
import Alert from '../components/ScudoTheming/Alert.vue';
import { useSessionStore } from '@/stores/session.js';
import { useRouter } from 'vue-router';

const router = useRouter();
const API = inject("api");
const Session = useSessionStore();

if (Session.data.token !== '') {
	router.push('/')
}

var form = reactive({
	username: '',
	fullname: '',
	email: '',
	password: '',
	confirmPassword: '',
	phone: '',
	pro: false,
})

function togglePro() {
	form.pro = !form.pro;
}

var classConfirmPassword = ref('default');

function changeClassConfirmPassword() {
	if (form.confirmPassword === '' || form.confirmPassword === form.password) {
		classConfirmPassword.value = 'default'
	} else {
		classConfirmPassword.value = 'wrong'
	}
	return null
}

var message = ref('')
function isValidForm() {
	console.log(navigator.onLine)
	if (navigator.onLine === false) {
		message.value = 'Erreur de connexion.'
		console.log(message)
		return null;
	}
	if (form.username.length <= 3) {
		message.value = 'Votre pseudo doit contenir plus de 3 caractères.'
		return null;
	} else if (form.password.length === 0) {
		message.value = 'Veuillez entrer un mot de passe.'
		return null;
	} else if (form.password !== form.confirmPassword) {
		message.value = "Votre mot de passe de confirmation n'est pas le même."
		return null;
	}

	if (form.pro) {
		API.post('/api/register', {
			fullname: form.fullname,
			username: form.username,
			email: form.email,
			password: form.password,
			phone: form.phone,
			role: 'professional',
		}).then((result) => {
			Session.setSession(result.data.token)
			router.push('/')
		}).catch((error) => {
			message.value = error.response.data.error
			return null
		})
	} else {
		API.post('/api/register', {
			username: form.username,
			email: form.email,
			password: form.password,
			role: 'individual',
		}).then((result) => {
			Session.setSession(result.data.token)
			router.push('/')
		}).catch((error) => {
			message.value = error.response.data.error
			return null
		})
	}
}
</script>

<template>
	<MainFeed>
		<Title>Inscrivez-vous !</Title>
		<form action="/api/register" method="post" @submit.prevent="isValidForm">
			<Text>
				<label for="role" class="form-control">Profil professionnel</label>
				<input @click="togglePro" id="role" name="role" type="checkbox" />
			</Text>
			<Input type="email" name="email" :required="true" label="Email" v-model:value="form.email" />
			<Input v-if="form.pro === true" input="tel" name="phone" :required="true" label="Numéro de téléphone"
				v-model:value="form.phone" />
			<Input v-if="form.pro === true" name="fullname" :required="true" label="Nom complet"
				v-model:value="form.fullname" />
			<Input name="username" :required="true" label="Pseudo" v-model:value="form.username" />
			<Input type="password" name="password" :required="true" label="Mot de passe" v-model:value="form.password" />
			<Input id="confirmPassword" type="password" name="confirmPassword" :required="true"
				label="Confirmer votre mot de passe" v-model:value="form.confirmPassword" :class="classConfirmPassword"
				v-on:input="changeClassConfirmPassword" />
			<Alert id="error" v-if="message !== ''">{{ message }}</Alert>
			<Button>S'inscrire</Button>
		</form>
		<RouterLink to="/login">
			<Button>Déjà un compte ?</Button>
		</RouterLink>
	</MainFeed>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

* {
	box-sizing: border-box;

	&::before,
	&::after {
		box-sizing: border-box;
	}
}

p,
label {
	line-height: 1.625rem;
	cursor: pointer;
}

p {
	display: flex;
	justify-content: space-between;
}

label {
	flex-grow: 1;
}

input[type="checkbox"] {
	position: relative;
	width: 1.5em;
	height: 1.5em;
	color: $light-text-primary;
	border: solid 1px $light-border;
	border-radius: 50%;
	vertical-align: bottom;
	appearance: none;
	outline: 0;
	cursor: pointer;
	background: transparent;
	transition: background 150ms ease-out;

	&::before {
		position: absolute;
		content: "";
		display: block;
		top: 2px;
		left: 7px;
		width: 8px;
		height: 14px;
		border-style: solid;
		border-color: $light-bg-primary;
		border-width: 0 2px 2px 0;
		transform: rotate(45deg) translate(-1px);
		opacity: 0;
	}

	&:checked {
		color: $light-text-button-alert;
		border-color: $light-bg-button;
		background: $light-bg-button;

		&::before {
			opacity: 1;
		}

		~label::before {
			clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
		}
	}
}

button {
	width: calc(100% - 1.5rem);
}

div.border.default {
	border: 1px solid $light-border;
}

div.border.wrong {
	border: 1px solid $light-bg-alert;
}

#error {
	margin-left: 0;
	width: 100%;
	text-align: center;
}
</style>
