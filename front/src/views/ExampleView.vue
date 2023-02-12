<script setup>
import ResourceCard from '@/components/ResourceCard.vue';

var user = {
  username: 'john_doe',
  image: 'https://miro.medium.com/max/785/0*Ggt-XwliwAO6QURi.jpg',
}
var resource = {
  title: 'En vacances !!',
  description: 'Lorem Elsass ipsum Spätzle Salu bissame leo elementum knack Oberschaeffolsheim risus, kougelhopf mollis Verdammi eget chambon hop nüdle Carola adipiscing amet nullam aliquam libero, ac quam, sagittis hopla knepfle tristique.',
  image: 'https://www.dynamique-mag.com/wp-content/uploads/894ed90a3cce65ec6aa1f61b351a1364.jpg'
}
</script>

<template>
  <main>
    <ResourceCard :user="user" :resource="resource" />
  </main>
  <aside>
    sza
  </aside>
</template>


