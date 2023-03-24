<script setup>
import { reactive, inject } from "vue";
import { useRouter, useRoute } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';
import MainFeed from '../components/ScudoTheming/MainFeed.vue';
import AsideFeed from '../components/ScudoTheming/AsideFeed.vue';
import RecordDisplay from '../components/RecordDisplay.vue';
import Input from "@/components/ScudoTheming/Input.vue";
import Text from '@/components/ScudoTheming/Text.vue';
import Title from "@/components/ScudoTheming/Title.vue"
import Card from "../components/ScudoTheming/Card.vue";
import FilledButton from "../components/ScudoTheming/FilledButton.vue";
import AddGroup from "../components/AddGroup.vue";


const API = inject("api");
const router = useRouter();
const route = useRoute();
const Session = useSessionStore();

var form = reactive({
  resource: {
    id: route.params.id,
    title: '',
    text: '',
    type: 'text',
  },
  groups: []
})

function getResource() {
  API.get(`/api/resource/${form.resource.id}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
  }).catch(() => {
    alert('oups');
  })
}

function getGroups() {
  API.get(`/api/groups`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.groups = reponse.data.result.group;
  }).catch(() => {
    alert('oups');
  })
}

getGroups();
getResource();
</script>

<template>
  <MainFeed>
    <Card>
      <AddGroup v-for="group in form.groups" :group="group" :resource="form.resource" />
    </Card>
  </MainFeed>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

p,
label {
  line-height: 1.625rem;
  cursor: pointer;
}

p {
  display: flex;
  justify-content: space-between;
}

label {
  flex-grow: 1;
}

// @import "@/assets/scss/media-queries";
input[type="checkbox"] {
  position: relative;
  width: 1.5em;
  height: 1.5em;
  color: $light-text-primary;
  border: solid 1px $light-border;
  border-radius: 50%;
  vertical-align: bottom;
  appearance: none;
  outline: 0;
  cursor: pointer;
  background: transparent;
  transition: background 150ms ease-out;

  &::before {
    position: absolute;
    content: "";
    display: block;
    top: 2px;
    left: 7px;
    width: 8px;
    height: 14px;
    border-style: solid;
    border-color: $light-bg-primary;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg) translate(-1px);
    opacity: 0;
  }

  &:checked {
    color: $light-text-button-alert;
    border-color: $light-bg-button;
    background: $light-bg-button;

    &::before {
      opacity: 1;
    }

    ~label::before {
      clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    }
  }
}
</style>