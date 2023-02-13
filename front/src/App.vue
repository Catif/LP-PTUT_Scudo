<script setup>
import Navbar from "./components/Navbar.vue";
import ResourceCard from "./components/ResourceCard.vue";

var user = {
  id: 12,
  username: 'john_doe',
  image: 'https://miro.medium.com/max/785/0*Ggt-XwliwAO6QURi.jpg',
}
var resource = {
  title: 'En vacances !!',
  description: 'Lorem Elsass ipsum Spätzle Salu bissame leo elementum knack Oberschaeffolsheim risus, kougelhopf mollis Verdammi eget chambon hop nüdle Carola adipiscing amet nullam aliquam libero, ac quam, sagittis hopla knepfle tristique.',
  image: 'https://thumbs.dreamstime.com/b/l-%C3%AEle-d%C3%A9serte-avec-le-palmier-sur-la-plage-35138358.jpg'
}
var group = {
  name: 'CGT 54',
  followers: 12000,
  image: 'https://orgasociaux.cgt.fr/wp-content/uploads/miniature-retraite-decembre-2.jpg'
}
</script>

<template>
  <div id="content">
    <ResourceCard :user="user" :resource="resource" :group="group"/>
    <Navbar />
    <RouterView />
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/media-queries.scss";

@media screen and (min-width: calc($navigation-bar-min-width + $content-min-width)) {
  #content {
    display: flex;
  }
}
</style>
