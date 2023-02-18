<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import Title from '../components/ScudoTheming/Title.vue';
import Input from '../components/ScudoTheming/Input.vue';
import Button from '../components/ScudoTheming/Button.vue';
import Alert from '../components/ScudoTheming/Alert.vue';
import { useSessionStore } from '@/stores/session.js';
import { reactive, ref, inject } from 'vue';
import { useRouter } from 'vue-router';

var form = reactive({
    username: '',
    password: '',
})

const API = inject("api");
const router = useRouter();
const Session = useSessionStore();

if (Session.data.token !== '') {
    router.push('/')
}

var message = ref('')

function isValidForm() {
    if (form.username.length <= 3) {
        message.value = 'Votre pseudo doit contenir plus de 3 caractères.'
        return null;
    }
    API.post('/api/login', {
        username: form.username,
        password: form.password,
    }).then((result) => {
        Session.setSession(result.data.token)
        router.push('/')
    }).catch((error) => {
        message.value = error.response.data.error
        return null
    })
}

</script>

<template>
    <MainFeed>
        <Title>Connectez-vous !</Title>
        <form action="/api/login" method="post" @submit.prevent="isValidForm">
            <Input name="username" :required='true' label="Pseudo ou email" v-model:value="form.username" />
            <Input type="password" name="password" :required='true' label="Mot de passe"
                v-model:value="form.password" />
            <Alert id="error" v-if="message !== ''">{{ message }}</Alert>
            <Button>Se connecter</Button>
        </form>
        <RouterLink to="/register">
            <Button>Pas de compte ?</Button>
        </RouterLink>
    </MainFeed>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

button {
    width: calc(100% - 1.5rem);
    border: 1px solid $light-bg-button;
    background: $light-bg-button;
    color: white;

    &:hover {
        background: $light-bg-button-hover;
    }

    &:active {
        background: $light-bg-button-active;
    }
}

#error {
    margin-left: 0;
    width: 100%;
    text-align: center;
}
</style>