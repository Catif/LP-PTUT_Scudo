<script setup>
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import RecordDisplay from '../components/ScudoTheming/RecordDisplay.vue';

var id = 'az454cqsz324dcz6a934azd5dsc';

</script>

<template>
  <MainFeed>
    <RecordDisplay :id="id" />
  </MainFeed>
  <!-- <AsideFeed  :large="false">
  </AsideFeed> -->
</template>
