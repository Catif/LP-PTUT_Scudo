<script setup>
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";
import Alert from "@/components/ScudoTheming/Alert.vue";
import ResourceCard from "@/components/ResourceCard.vue";
import UserCard from "@/components/UserCard.vue";
import { useSessionStore } from "@/stores/session.js";
import { inject, ref, reactive } from "vue";
import { useRoute } from "vue-router";

const bus = inject("bus");
const API = inject("api");
const route = useRoute();
const Session = useSessionStore();
const user = ref(null);
const resources = ref(null);
const message = reactive({
  content: "",
  type: "",
});

API.get(`/api/user/${route.params.id}`, {
  headers: {
    Authorization: Session.data.token,
  },
})
  .then((response) => {
    let result = response.data.result;

    message.content = "";

    result.user.following = result.following;
    result.user.owner = result.owner;
    result.user.nb_followers = result.nb_followers; // follow me
    result.user.nb_following = result.nb_follows; // is following
    user.value = result.user;
  })
  .catch((error) => {
    message.content = error.response.data.error;
  });

API.get(`api/user/${route.params.id}/resources?page=1&limit=10`, {
  headers: {
    Authorization: Session.data.token,
  },
})
  .then((result) => {
    message.content = "";
    resources.value = result.data.result.resources;
  })
  .catch((error) => {
    message.content = error.response.data.error;
  });

bus.on("actionFollow", (event) => {
  message.type = event[1];
  if (message.type == "success") {
    user.value.following = !user.value.following;

    if (user.value.following) {
      user.value.nb_followers++;
    } else {
      user.value.nb_followers--;
    }
  } else if (message.type == "error") {
    message.content = event[0];
  }

  setTimeout(() => {
    message.content = "";
  }, 3000);
});
</script>

<template>
  <MainFeed>
    <Alert v-if="message.content !== ''" :class="message.type">{{
      message.content
    }}</Alert>
    <template v-if="message.content === ''">
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
