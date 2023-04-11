<script setup>

import { reactive, inject } from "vue";
import { useRouter, useRoute } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';
import MainFeed from '@/components/ScudoTheming/MainFeed.vue';
import Input from "@/components/ScudoTheming/Input.vue";
import Text from '@/components/ScudoTheming/Text.vue';
import Card from "@/components/ScudoTheming/Card.vue";
import FilledButton from "@/components/ScudoTheming/FilledButton.vue";
import Button from "@/components/ScudoTheming/Button.vue";
import Icon from "@/components/ScudoTheming/Icon.vue";
import EditTopAppBar from "@/components/EditTopAppBar.vue";

const API = inject("api");
const router = useRouter();
const route = useRoute();
const Session = useSessionStore();

var form = reactive({
  resource: {
    id: route.params.id,
    title: '',
    text: '',
    type: 'video',
  },
  is_public: false,
  errorMessage: '',
})

function saveResource() {
  form.errorMessage = '';
  if (form.is_public) {
    var is_private = 0;
  } else {
    var is_private = 1;
  }

  API.post(`/api/resource/${form.resource.id}`, {
    title: form.resource.title,
    text: form.resource.text,
    type: form.resource.type,
    is_private: is_private,
  }, {
    headers: {
      Authorization: Session.data.token
    }
  }).then(() => {
    router.push({ name: "resourceById", params: { id: form.resource.id } })
  }).catch((error) => {
    console.log(error)
    form.errorMessage = 'Un problème est survenu lors de la sauvgarde, vérifiez votre connexion internet et réessayez.'
  })
}

function getResource() {
  API.get(`/api/resource/${form.resource.id}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
    if (reponse.data.result.resource.is_private == 1) {
      form.is_public = false;
    } else {
      form.is_public = true;
    }
  }).catch(() => {
    alert('Vous ne pouvez pas modifier cette resource.');
    router.push({ name: "resourceById", params: { id: route.params.id } });

  })
}

function shareResource() {
  router.push({ name: "shareResourceById", params: { id: form.resource.id } })
}

getResource();
</script>

<template>
  <MainFeed>
    <EditTopAppBar :resource="form.resource" />
    <form @submit.prevent="saveResource">
      <Card>
        <Input name="title" label="Titre" v-model:value="form.resource.title" />
        <Input name="text" label="Description" v-model:value="form.resource.text" />
        <Text>
          <label for="role" class="form-control">Partager publiquement</label>
          <input id="role" name="role" type="checkbox" v-model="form.is_public" />
        </Text>
        <Text v-if="form.errorMessage != ''">{{ form.errorMessage }}</Text>
        <Button @click="shareResource">
          <div>
            <span>Partager dans mes groupes </span>
            <Icon>chevron_right</Icon>
          </div>
        </Button>
        <FilledButton>ENREGISTRER</FilledButton>
      </Card>
    </form>
  </MainFeed>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries";

p,
label {
  line-height: 1.625rem;
  cursor: pointer;
}

button {
  width: calc(100% - 1.5rem);

  div {
    width: 100%;
    display: flex;
    justify-content: space-between;
  }
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