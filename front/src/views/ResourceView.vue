<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import ResourceDisplay from '../components/ResourceDisplay.vue';

var type = 'video';

function api_getResourceById(id) {
  return {
    id: id,
    title: 'En vacances !!',
    description: 'Lorem Elsass ipsum Spätzle Salu bissame leo elementum knack Oberschaeffolsheim risus, kougelhopf mollis Verdammi eget chambon hop nüdle Carola adipiscing amet nullam aliquam libero, ac quam, sagittis hopla knepfle tristique.',
    image: 'https://thumbs.dreamstime.com/b/l-%C3%AEle-d%C3%A9serte-avec-le-palmier-sur-la-plage-35138358.jpg',
    type: type,
    filename: `video-${id}.mp4`
  }
}

</script>

<template>
  <MainFeed>
    <ResourceDisplay :resource="api_getResourceById($route.params.id)" />
  </MainFeed>
  <!-- <AsideFeed  :large="false">
  </AsideFeed> -->
</template>
