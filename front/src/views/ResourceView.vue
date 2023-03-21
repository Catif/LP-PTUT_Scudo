<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import Input from '../components/ScudoTheming/Input.vue';
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
  comments: [],
  newComment: '',
  auteur: {
    url: {
      image: ''
    }
  }
})

function getResource() {
  API.get(`/api/resource/${form.resource.id}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
    form.comments = reponse.data.result.comments;
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

function getComments() {
  API.get(`/api/comment/${form.resource.id_user}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.resource.comments = reponse.data.result;
  }).catch(() => {
    alert('oups');
  })
}

function postComment() {
  API.post(`/api/comment/${form.resource.id}`, {
    content: form.newComment,
  }, {
    headers: {
      Authorization: Session.data.token
    }
  }).then(() => {
    // getComments();
    getResource();
    form.newComment = ''
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
      <div v-if="typeof (form.comments) != 'undefined'">
        <Card>
          <Title>COMMENTAIRES</Title>
        </Card>
        <CommentCard v-for="comment in form.comments" :comment="comment" />
      </div>
      <Card>
        <form @submit.prevent="postComment">
          <Input name="commentaire" placeholder="Ajouter un commentaire" v-model:value="form.newComment" />
        </form>
      </Card>
    </div>
  </MainFeed>



  <AsideFeed :large="true">
    <Card>
      <AuthorSection :user="form.auteur" :title="form.resource.title" />
      <Description v-if="form.resource.text != ''" :description="form.resource.text" />
    </Card>
    <div v-if="typeof (form.comments) != 'undefined'">
      <Card>
        <Title>COMMENTAIRES</Title>
      </Card>
      <CommentCard v-for="comment in form.comments" :comment="comment" />
    </div>
    <Card>
      <form @submit.prevent="postComment">
        <Input name="commentaire1" placeholder="Ajouter un commentaire" v-model:value="form.newComment" />
      </form>
    </Card>
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
