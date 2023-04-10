<script setup>
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";
import Alert from "@/components/ScudoTheming/Alert.vue";
import ResourceCard from "@/components/ResourceCard.vue";
import UserCard from "@/components/UserCard.vue";
import { useSessionStore } from "@/stores/session.js";
import { inject, ref } from "vue";
import { useRoute } from "vue-router";
const API = inject("api");
const route = useRoute();
const Session = useSessionStore();
const user = ref(null);
const resources = ref(null);
const message = ref("");

API.get(`/api/user/${route.params.id}`, {
  headers: {
    Authorization: Session.data.token,
  },
})
  .then((response) => {
    let result = response.data.result;

    message.value = "";

    result.user.following = result.following;
    result.user.owner = result.owner;
    result.user.nb_followers = result.nb_followers; // follow me
    result.user.nb_following = result.nb_follows; // is following
    user.value = result.user;
  })
  .catch((error) => {
    message.value = error.response.data.error;
  });

API.get(`api/user/${route.params.id}/resources?page=1&limit=10`, {
  headers: {
    Authorization: Session.data.token,
  },
})
  .then((result) => {
    message.value = "";
    resources.value = result.data.result.resources;
  })
  .catch((error) => {
    message.value = error.response.data.error;
  });
</script>

<template>
  <MainFeed>
    <Alert v-if="message !== ''" class="error">{{ message }}</Alert>
    <template v-if="message === ''">
      <template v-if="user">
        <UserCard :user="user" />
        <template v-for="resource in resources">
          <ResourceCard :user="user" :resource="resource" />
        </template>
      </template>
    </template>
  </MainFeed>
</template>

<style lang="scss" scoped>
.error {
  width: 100%;
  text-align: center;
}
</style>
