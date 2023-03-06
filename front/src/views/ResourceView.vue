<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import ResourceDisplay from '../components/ResourceDisplay.vue';
import { inject, reactive } from 'vue';
import { useSessionStore } from '@/stores/session.js';
import { useRoute } from "vue-router";

const route = useRoute();
const Session = useSessionStore();
const API = inject("api");
const bus = inject('bus')
const form = reactive({
  resource: {
    id: route.params.id,
    type: ''
  }
})

API.get(`/api/resource/${form.resource.id}`, {
  headers: {
    Authorization: Session.data.token,
  },
}).then((reponse) => {
  form.resource = reponse.data.result.resource;
}).catch(() => {
  alert('oups');
})

bus.on('refreshResource', function () {
  API.get(`/api/resource/${form.resource.id}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
  }).catch(() => {
    alert('oups');
  })
})

</script>

<template>
  <MainFeed>
    <ResourceDisplay v-if="form.resource.type != ''" :resource="form.resource" />
  </MainFeed>
  <!-- <AsideFeed  :large="false">
                                                                                                                  </AsideFeed> -->
</template>
