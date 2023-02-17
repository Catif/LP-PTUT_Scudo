<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import DefaultTopAppBar from '../components/DefaultTopAppBar.vue';
import Button from '../components/ScudoTheming/Button.vue';
import ResourceCard from '@/components/ResourceCard.vue';
import GroupCard from '@/components/SmallGroupCard.vue';
import { useSessionStore } from '@/stores/session.js';

const Session = useSessionStore();

var user = {
  id: 12,
  username: 'john_doe',
  image: 'https://miro.medium.com/max/785/0*Ggt-XwliwAO6QURi.jpg',
}
var resource = {
  title: 'En vacances !!',
  description: 'Lorem Elsass ipsum Spätzle Salu bissame leo elementum knack Oberschaeffolsheim risus, kougelhopf mollis Verdammi eget chambon hop nüdle Carola adipiscing amet nullam aliquam libero, ac quam, sagittis hopla knepfle tristique.',
  image: 'https://thumbs.dreamstime.com/b/l-%C3%AEle-d%C3%A9serte-avec-le-palmier-sur-la-plage-35138358.jpg',
  type: 'live',
}

var resource1 = {
  title: 'Au travail !!',
  description: 'Lorem Elsass ipsum Spätzle Salu bissame leo elementum knack Oberschaeffolsheim risus, kougelhopf mollis Verdammi eget chambon hop nüdle Carola adipiscing amet nullam aliquam libero, ac quam, sagittis hopla knepfle tristique.',
  image: 'https://upload.itg.fr/files/salaries-francais-quete-sens-travail.jpg',
  type: 'video',
}
var group = {
  name: 'CGT 54',
  followers: 12000,
  image: 'https://orgasociaux.cgt.fr/wp-content/uploads/miniature-retraite-decembre-2.jpg'
}
</script>

<template>
  <MainFeed>
    <DefaultTopAppBar />
    <Button @click="Session.emptySession()">Se déconnecter</Button>
    <ResourceCard :user="user" :resource="resource" />
    <ResourceCard :user="user" :resource="resource" />
    <ResourceCard :user="user" :resource="resource1" :group="group" />
    <ResourceCard :user="user" :resource="resource" />
    <ResourceCard :user="user" :resource="resource" :group="group" />
    <ResourceCard :user="user" :resource="resource" :group="group" />
    <ResourceCard :user="user" :resource="resource1" />
    <ResourceCard :user="user" :resource="resource1" />
    <ResourceCard :user="user" :resource="resource" :group="group" />
  </MainFeed>
  <AsideFeed>
    <GroupCard :group="group" />
    <GroupCard :group="group" />
    <GroupCard :group="group" />
    <GroupCard :group="group" />
    <GroupCard :group="group" />
    <GroupCard :group="group" />
  </AsideFeed>
</template>


