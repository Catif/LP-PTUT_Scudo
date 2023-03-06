<script setup>
import Title from "@/components/ScudoTheming/Title.vue"
import { reactive, inject } from "vue";
import BottomSheetScaffold from "@/components/ScudoTheming/BottomSheetScaffold.vue";
import Input from "@/components/ScudoTheming/Input.vue";
import { useRouter, useRoute } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';
import Text from '@/components/ScudoTheming/Text.vue';
import MainFeed from '@/components/ScudoTheming/MainFeed.vue';
import AsideFeed from '@/components/ScudoTheming/AsideFeed.vue';
import RecordDisplay from '@/components/RecordDisplay.vue';
import FloatingAppButton from "../components/ScudoTheming/FloatingAppButton.vue";
import Icon from "../components/ScudoTheming/LargeIcon.vue";
import Card from "../components/ScudoTheming/Card.vue";

const API = inject("api");
const router = useRouter();
const route = useRoute();
const Session = useSessionStore();
const bus = inject('bus')

var form = reactive({
  resource: {
    id: null,
    title: '',
    text: '',
    type: 'text',
    is_private: 1,
  }
})
if (route.params.accessibility == 'public') {
  form.resource.is_private = 0;
}

function createResource() {
  API.post('/api/resource', {
    title: form.resource.title,
    text: form.resource.text,
    type: form.resource.type,
    is_private: form.resource.is_private,
  }, {
    headers: {
      Authorization: Session.data.token
    }
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
  }).catch(() => {
    alert('oups')
  })
}

function saveResource() {
  API.post(`/api/resource/${form.resource.id}`, {
    title: form.resource.title,
    text: form.resource.text,
    type: form.resource.type,
    is_private: form.resource.is_private,
  }, {
    headers: {
      Authorization: Session.data.token
    }
  }).then((reponse) => {
    form.resource = reponse.data.result.Resource;
  }).catch(() => {
    alert('oups');
  })
}

function toggleAccessibility() {

  if (form.resource.is_private) {
    router.push('/record/private');
    form.resource.is_private = 1;
  } else {
    router.push('/record/public');
    form.resource.is_private = 0;
  }

  saveResource();
}

function startStopRecord() {
  if (form.resource.type == 'stream') {
    stopRecord();
  } else {
    startRecord();
  }
}

function startRecord() {
  form.resource.type = 'stream';
}

function stopRecord() {
  form.resource.type = 'video';
  saveResource();
  bus.emit('stopRecord');
  alert('rediriger vers édition resource');
}

bus.on('changeOK', function () {
  saveResource();
})

bus.on('recordOK', function () {
  saveResource();
})

createResource();
</script>

<template>
  <MainFeed>
    <!-- FORMULAIRE ÉDITION DE RESOURCE AVANT LE LIVE -->
    <form v-if="form.resource.type != 'stream'">
      <Card>
        <Title>Démarrer un enregistrement</Title>
        <Input name="title" label="Titre" v-model:value="form.resource.title" />
        <Input name="text" label="Description" v-model:value="form.resource.text" />
        <Text>
          <label for="role" class="form-control">Partager publiquement</label>
          <input @click="toggleAccessibility" id="role" name="role" type="checkbox" />
        </Text>
      </Card>
    </form>

    <!-- RETOUR LIVE -->
    <div id="recordDisplay">
      <RecordDisplay v-if="form.resource.type == 'stream'" :id="form.resource.id" />
    </div>
    <FloatingAppButton @click="startStopRecord">
      <Icon v-if="form.resource.type == 'text'">fiber_manual_record</Icon>
      <Icon v-else>stop</Icon>
    </FloatingAppButton>
  </MainFeed>

  <!-- FORMULAIRE ÉDITION DE RESOURCE PENDANT LE LIVE -->
  <template v-if="form.resource.type == 'stream'">
    <BottomSheetScaffold>
      <form>
        <Card>
          <Input name="title" label="Titre" v-model:value="form.resource.title" />
          <Input name="text" label="Description" v-model:value="form.resource.text" />
          <Text>
            <label for="role" class="form-control">Partager publiquement</label>
            <input @click="toggleAccessibility" id="role" name="role" type="checkbox" />
          </Text>
        </Card>
      </form>
    </BottomSheetScaffold>
    <AsideFeed :large="true">
      <form>
        <Card>
          <Input name="title" label="Titre" v-model:value="form.resource.title" />
          <Input name="text" label="Description" v-model:value="form.resource.text" />
          <Text>
            <label for="role" class="form-control">Partager publiquement</label>
            <input @click="toggleAccessibility" id="role" name="role" type="checkbox" />
          </Text>
        </Card>
      </form>
    </AsideFeed>
  </template>
</template>
<style lang="scss" scoped>
@import "@/assets/scss/colors";

main {
  position: relative;

  button {
    position: absolute;
    bottom: .75rem;
    left: 50%;
    transform: translateX(-50%);
  }
}

#recordDisplay {
  position: fixed;
  top: 0;
}

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