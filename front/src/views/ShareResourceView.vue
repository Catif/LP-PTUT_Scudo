<script setup>
import { reactive, inject } from "vue";
import { useRouter, useRoute } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import RecordDisplay from '../components/RecordDisplay.vue';
import Input from "@/components/ScudoTheming/Input.vue";
import Text from '@/components/ScudoTheming/Text.vue';
import Title from "@/components/ScudoTheming/Title.vue"
import Card from "../components/ScudoTheming/Card.vue";
import FilledButton from "../components/ScudoTheming/FilledButton.vue";
import AddGroup from "../components/AddGroup.vue";
import DefaultTopAppBar from "../components/DefaultTopAppBar.vue";


const API = inject("api");
const router = useRouter();
const route = useRoute();
const Session = useSessionStore();

var form = reactive({
  resource: {
    id: route.params.id,
  },
  groups: [],
  errorMessage: ''
})

function validateGroups() {
  API.get(`/api/resource/${form.resource.id}/groups`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    reponse.data.result.groups.forEach(group_validated => {
      form.groups.map(group => group.id == group_validated.id ? group.shared = true : null)
    });
  }).catch(() => {
    alert('Récupération de vos groupes échouée.');
    router.push({ name: "editResourceById", params: { id: form.resource.id } });
  })
}

function getGroups() {
  API.get(`/api/user/${Session.data.idUser}/groups`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.groups = reponse.data.result.groups;
    if (form.groups.length == 0) {
      form.errorMessage = "Abonnez-vous d'abord à un groupe avant de pouvoir y partager du contenu.";
    } else {
      validateGroups();
    }
  }).catch(() => {
    alert('Récupération de vos groupes échouée.');
    router.push({ name: "editResourceById", params: { id: form.resource.id } });
  })
}

getGroups();
</script>

<template>
  <MainFeed :top-app-bar="true">
    <DefaultTopAppBar title="Partager" :back="true" />
    <Card>
      <Text v-if="form.errorMessage != ''">{{ form.errorMessage }}</Text>
      <AddGroup v-for="group in form.groups" :group="group" :resource="form.resource" />
    </Card>
  </MainFeed>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

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

// @import "@/assets/scss/media-queries";
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
</style>