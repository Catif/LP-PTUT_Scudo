<script setup>
import TopAppBar from '../components/ScudoTheming/TopAppBar.vue';
import Title from '../components/ScudoTheming/Title.vue';
import Text from '../components/ScudoTheming/Text.vue';
import Input from '../components/ScudoTheming/Input.vue';
import Button from '../components/ScudoTheming/Button.vue';
import Alert from '../components/ScudoTheming/Alert.vue';
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import { useSessionStore } from '@/stores/session.js';
import { reactive, ref, inject } from 'vue';
import { useRouter } from 'vue-router';

var form = reactive({
    old_password: '',
    new_password: '',
    new_password_repeat: ''
})

const API = inject("api");
const router = useRouter();
const Session = useSessionStore();


if (Session.data.token == '') {
    router.push('/')
}

var message = reactive({
    content: '',
    type: ''
})


let fileData = new FormData();
fileData.append("file", form.new_password);

let config = {
    headers: {
        "Content-Type": "multipart/form-data",
        Authorization: Session.data.token,
    },
};

function isValidFormParams() {
    if (form.new_password != form.new_password_repeat) {
        message.value = "Vous n'avez pas saisi le même nouveau mot de passe"
        return null;
    }
    API.post('/api/user/password_change',{
        old_password: form.old_password,
        new_password: form.new_password,
        new_password_repeat: form.new_password_repeat
    }, config,
    ).then(() => {
        message.type = "success"
        message.content = "Votre mot de passe a bien été changé"
        return null
    }).catch((error) => {
        message.type = "error"
        message.content = error.response.data.error
        return null
    })
}

</script>

<template>
    <MainFeed>
        <TopAppBar></TopAppBar>
        <Title>Paramètre !</Title>
        <Text>Changer son mot de passe</Text>
        <form action="/api/user/password_change" method="post" @submit.prevent="isValidFormParams">
            <Input type="password" name="old_password" :required='true' label="Ancien mot de passe" v-model:value="form.old_password" />
            <Input type="password" name="new_password" :required='true' label="Nouveau mot de passe" v-model:value="form.new_password" />
            <Input type="password" name="new_password_repeat" :required='true' label="Vérification du nouveau mot de passe" v-model:value="form.new_password_repeat" />
            <Alert id="success" :type="message.type" v-if="message.content !== ''">{{ message.content }}  </Alert>
            <Button>CONFIRMER</Button>
            <RouterLink to="/"></RouterLink>
        </form>
        <form @submit=" Session.emptySession()">
            <Button>Déconnexion</Button>
        
        </form>
       
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
