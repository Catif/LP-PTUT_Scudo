<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import ResourceDisplay from '../components/ResourceDisplay.vue';
import { inject, reactive } from 'vue';
import { useSessionStore } from '@/stores/session.js';

const Session = useSessionStore();
const API = inject("api");
const form = reactive({
  resource: {
    id: '4628eb12-4276-4d71-a96b-c695e8ec6dc4',
    type: ''
  }
})

API.get(`/api/resource/${form.resource.id}`, {
  headers: {
    Authorization: Session.data.token,
  },
}).then((reponse) => {
  form.resource = reponse.data.result.resource;
  console.log(reponse);
}).catch(() => {
  alert('oups');
})

</script>

<template>
  <MainFeed>
    <ResourceDisplay v-if="form.resource.type != ''" :resource="form.resource" />
  </MainFeed>
  <!-- <AsideFeed  :large="false">
                                                                              </AsideFeed> -->
</template>
