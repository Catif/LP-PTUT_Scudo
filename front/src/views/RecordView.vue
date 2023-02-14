<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import RecordDisplay from '../components/ScudoTheming/RecordDisplay.vue';
</script>

<template>
  <MainFeed>
    <RecordDisplay :id="$route.params.id" />
  </MainFeed>
  <!-- <AsideFeed  :large="false">
  </AsideFeed> -->
</template>
