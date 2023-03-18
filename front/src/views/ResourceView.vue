<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import ResourceDisplay from '../components/ResourceDisplay.vue';
import CommentCard from '../components/CommentCard.vue';
import AuthorSection from '../components/AuthorSection.vue';
import Description from '../components/Description.vue';
import { inject, reactive } from 'vue';
import { useSessionStore } from '@/stores/session.js';
import { useRoute } from "vue-router";
import Card from '../components/ScudoTheming/Card.vue';
import Text from '../components/ScudoTheming/Text.vue';
import Title from '../components/ScudoTheming/Title.vue';

const route = useRoute();
const Session = useSessionStore();
const API = inject("api");
const bus = inject('bus')
const form = reactive({
  resource: {
    id: route.params.id,
    type: ''
  },
  auteur: {}
})

function getResource() {
  API.get(`/api/resource/${form.resource.id}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
    getAuteur();
  }).catch(() => {
    alert('oups');
  })
}

function getAuteur() {
  API.get(`/api/user/${form.resource.id_user}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.auteur = reponse.data.result.user;
  }).catch(() => {
    alert('oups');
  })
}

bus.on('refreshResource', function () {
  getResource();
})

getResource();


</script>

<template>
  <MainFeed :TopAppBar="false">
    <ResourceDisplay v-if="form.resource.type != ''" :resource="form.resource" />
    <div id="resourceDatasS">
      <Card>
        <AuthorSection :user="form.auteur" :title="form.resource.title" />
        <Description v-if="form.resource.text != ''" :description="form.resource.text" />
      </Card>
      <div v-if="typeof (form.resource.comments) != 'undefined'">
        <Title>COMMENTAIRES</Title>
        <CommentCard v-for="comment in form.resource.comments">A</CommentCard>
      </div>
    </div>
  </MainFeed>
  <AsideFeed :large="true">
    <Card>
      <AuthorSection :user="form.auteur" :title="form.resource.title" />
      <Description v-if="form.resource.text != ''" :description="form.resource.text" />
    </Card>
    <div v-if="typeof (form.resource.comments) != 'undefined'">
      <Title>COMMENTAIRES</Title>
      <CommentCard v-for="comment in form.resource.comments">A</CommentCard>
    </div>
  </AsideFeed>
</template>
<style lang="scss" scoped>
@import "@/assets/scss/media-queries";

@media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $content-min-width + 24px)) {
  #resourceDatasS {
    display: none;
  }
}
</style>
