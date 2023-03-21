<script setup>
import { reactive, inject } from "vue";
import { useRouter, useRoute } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import RecordDisplay from '../components/RecordDisplay.vue';

const API = inject("api");

var form = reactive({
  resource: {
    id: null,
    title: '',
    text: '',
    type: 'text',
  },
  is_public: false,
})
if (route.params.accessibility == 'public') {
  form.is_public = true;
}

function saveResource() {
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
  }).then((reponse) => {
    form.resource = reponse.data.result.Resource;
  }).catch(() => {
    alert('oups');
  })
}

function toggleAccessibility() {

  if (form.is_public) {
    router.push('/record/private');
  } else {
    router.push('/record/public');
  }

  saveResource();
}
</script>

<template>
  <MainFeed>
    <Card>
      <!-- <Title>Démarrer un enregistrement</Title> -->
      <Input name="title1" label="Titre" v-model:value="form.resource.title" />
      <Input name="text1" label="Description" v-model:value="form.resource.text" />
      <Text>
        <label for="role1" class="form-control">Partager publiquement</label>
        <input @click="toggleAccessibility" id="role1" name="role1" type="checkbox" v-model="form.is_public" />
      </Text>
    </Card>
  </MainFeed>
</template>
