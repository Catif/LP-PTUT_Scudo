<script setup>
import { reactive, ref } from 'vue';
import Title from '../components/ScudoTheming/Title.vue';
import Text from '../components/ScudoTheming/Text.vue';
import Input from '../components/ScudoTheming/Input.vue';
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import Button from '../components/ScudoTheming/Button.vue';

var form = reactive ({
        username: '',
        fullname: '',
        email: '',
        password: '',
        confirmPassword: '',
        phone:  '',
        pro: false,
})

function togglePro() {
        form.pro = !form.pro;
}

var classConfirmPassword = ref('default');

function changeClassConfirmPassword(){
        if(form.confirmPassword === ''){
                classConfirmPassword = 'default'
        }
        if(form.confirmPassword !== ''){
                if(form.password !== form.confirmPassword){
                        classConfirmPassword = 'wrong';
                }else if(form.password === form.confirmPassword){
                        classConfirmPassword = 'right';
                }
        }
}

</script>

<template>
<MainFeed>
        <Title>Inscrivez-vous !</Title>
        <Text>
                <label for="role" class="form-control">Profil professionnel</label>
                <input @click="togglePro" id="role" name="role" type="checkbox"/>
        </Text>
        <Input type="email" name="email" :required='true' label="Email" v-model:value="form.email"/>
        <Input v-if="form.pro === true" name="phone" :required='true' label="Numéro de téléphone" v-model:value="form.phone"/>
        <Input v-if="form.pro === true" name="fullname" :required='true' label="Nom complet" v-model:value="form.fullname"/>
        <Input name="username" :required='true' label="Pseudo" v-model:value="form.username"/>
        <Input type="password" name="password" :required='true' label="Mot de passe" v-model:value="form.password"/> 
        <Input id="confirmPassword" type="password" name="confirmPassword" :required='true' label="Confirmer votre mot de passe"
         v-model:value="form.confirmPassword" :class="classConfirmPassword" v-on:input="changeClassConfirmPassword"/>
        <Button>S'inscrire</Button>
</MainFeed>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
* {
  box-sizing: border-box;
  &::before, &::after {
    box-sizing: border-box;
  }
}
p,
label{
    line-height: 1.625rem;
    cursor: pointer;
}
p{
    display: flex;
    justify-content: space-between;
}
label{
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
    content: '';
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
    ~ label::before {
      clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    }
  }
}
button{
        width: 100%;
        margin-left: 0;
        border: 1px solid $light-bg-button;
}
</style>