<script setup>
import Title from "@/components/ScudoTheming/Title.vue"
import { reactive, inject } from "vue";
import IconButton from "./ScudoTheming/IconButton.vue";
import Input from "./ScudoTheming/Input.vue";
import FilledButton from "./ScudoTheming/FilledButton.vue";
import { useRouter, useRoute } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';


const API = inject("api");
const router = useRouter();
const route = useRoute();
const Session = useSessionStore();

var form = reactive({
  title: '',
  text: '',
  type: 'stream',
  is_private: true,
})

if (route.params.accessibility == 'public') {
  form.is_private = false;
}
else {
  form.is_private = true;
}

function saveResource() {
  API.post('/api/resource', {
    title: form.title,
    text: form.text,
    type: form.type,
    is_private: form.is_private,
  }, {
    headers: {
      'API-Token': Session.data.token
    }
  }).then((result) => {
    Session.setSession(result.data.token)
    router.push('/')
  })
}


function toggleAccessibility() {

  form.is_private = !form.is_private;

  if (form.is_private) {
    router.push('/record/private');
  } else {
    router.push('/record/public');
  }
}

saveResource();

</script>
<template>
  <IconButton>close</IconButton>
  <Title>Démarrer un enregistrement</Title>
  <Input name="title" label="Titre" v-model:value="form.title" />
  <Input name="text" label="Description" v-model:value="form.text" />
  <FilledButton @click="toggleAccessibility">top</FilledButton>
</template>
<style lang="scss" scoped></style>