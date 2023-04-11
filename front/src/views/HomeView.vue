<script setup>
// Importation de composants
import TopAppBar from "@/components/ScudoTheming/TopAppBar.vue";
import MainFeed from "@/components/ScudoTheming/MainFeed.vue";
import ResourceCard from "@/components/ResourceCard.vue";
import AsideFeed from "../components/ScudoTheming/AsideFeed.vue";
import SmallGroupCard from "../components/SmallGroupCard.vue";

// Importation de méthode
import { ref, inject } from "vue";

// Importation de store
import { useSessionStore } from "@/stores/session.js";

const API = inject("api");
const Session = useSessionStore();

const listResources = ref([]);
const listGroups = ref([]);

function getResources() {
  const config = {
    headers: {
      Authorization: Session.data.token,
    },
  };

  API.get("/api/resources?page=1&limit=20", config)
    .then((response) => {
      const data = response.data;
      data.result.resources.map((resource) => {
        loadUserForResource(resource.id_user).then((user) => {
          resource.user = user;
          listResources.value.push(resource);
        });
      });
    })
    .catch((err) => {
      console.log(err.response.data);
    });
}

function loadUserForResource(idUser) {
  let config = {
    headers: {
      Authorization: Session.data.token,
    },
  };
  return API.get(`/api/user/${idUser}`, config)
    .then((response) => {
      return response.data.result.user;
    })
    .catch((error) => {
      console.log(error);
    });
}

function getRandomGroups() {
  let config = {
    headers: {
      Authorization: Session.data.token,
    },
  };
  return API.get(`/api/groups/random?limit=5`, config)
    .then((response) => {
      listGroups.value = response.data.result.groups;
      listGroups.value.forEach((group, idx) => {
        API.get(`/api/group/${group.id}`, config)
          .then((response) => {
            const result = response.data.result;
            listGroups.value[idx].followers = result.followers;
          })
          .catch((error) => {
            console.log(error);
          });
      });
    })
    .catch((error) => {
      console.log(error);
    });
}

getResources();
getRandomGroups();
</script>

<template>
  <MainFeed>
    <TopAppBar></TopAppBar>
    <div id="listResources">
      <ResourceCard
        v-for="resource in listResources"
        :resource="resource"
        :user="resource.user"
      />
    </div>
  </MainFeed>

  <AsideFeed>
    <div id="listGroups">
      <SmallGroupCard v-for="group in listGroups" :group="group" />
    </div>
  </AsideFeed>
</template>
