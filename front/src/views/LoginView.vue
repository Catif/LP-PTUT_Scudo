<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import Title from '../components/ScudoTheming/Title.vue';
import Input from '../components/ScudoTheming/Input.vue';
import Button from '../components/ScudoTheming/Button.vue';
import { reactive } from 'vue';

var form = reactive ({
        username: '',
        password: '',
})

</script>

<template>
<MainFeed>
    <Title>Connectez-vous !</Title>
    <form action="/api/login" method="post">
        <Input name="username" :required='true' label="Pseudo ou email" v-model:value="form.username"/>
        <Input type="password" name="password" :required='true' label="Mot de passe" v-model:value="form.password"/>
        <Button>S'inscrire</Button>
    </form>
</MainFeed>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

button{
    width: 100%;
    margin-left: 0;
    border: 1px solid $light-bg-button;
}

</style>