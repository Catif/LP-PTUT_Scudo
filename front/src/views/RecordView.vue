<script setup>
import Title from "@/components/ScudoTheming/Title.vue"
import { reactive, inject } from "vue";
import ModalBottomSheet from "@/components/ScudoTheming/ModalBottomSheet.vue";
import Input from "@/components/ScudoTheming/Input.vue";
import { useRouter, useRoute } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';
import Text from '@/components/ScudoTheming/Text.vue';
import MainFeed from '@/components/ScudoTheming/MainFeed.vue';
import FilledButton from '@/components/ScudoTheming/FilledButton.vue';
import AsideFeed from '@/components/ScudoTheming/AsideFeed.vue';
import RecordDisplay from '@/components/RecordDisplay.vue';
import FloatingAppButton from "../components/ScudoTheming/FloatingAppButton.vue";
import Icon from "../components/ScudoTheming/LargeIcon.vue";
import Card from "../components/ScudoTheming/Card.vue";
import Button from "../components/ScudoTheming/Button.vue";

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
  },
  is_public: false,
})
if (route.params.accessibility == 'public') {
  form.is_public = true;
}

function createResource() {
  if (form.is_public) {
    var is_private = 0;
  } else {
    var is_private = 1;
  }

  API.post('/api/resource', {
    title: form.resource.title,
    text: form.resource.text,
    type: form.resource.type,
    is_private: is_private,
  }, {
    headers: {
      Authorization: Session.data.token
    }
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
    console.log(form.resource);
    if (route.params.accessibility == 'public') {
      router.push({ name: "record", params: { accessibility: 'public', id: form.resource.id } });
    } else {
      router.push({ name: "record", params: { accessibility: 'private', id: form.resource.id } });
    }
  }).catch(() => {
    router.push({ name: "home" });
  })
}



function getResource() {
  API.get(`/api/resource/${form.resource.id}`, {
    headers: {
      Authorization: Session.data.token,
    },
  }).then((reponse) => {
    form.resource = reponse.data.result.resource;
    console.log(form.resource);
    if (reponse.data.result.resource.is_private == 1) {
      form.is_public = false;
    } else {
      form.is_public = true;
    }
  }).catch(() => {
    alert('Vous ne pouvez pas modifier cette resource.');
    router.push({ name: "resourceById", params: { id: route.params.id } });

  })
}

function saveResource() {
  form.errorMessage = '';
  if (form.is_public) {
    var is_private = 0;
  } else {
    var is_private = 1;
  }

  API.post(`/api/resource/${form.resource.id}`, {
    title: form.resource.title,
    text: form.resource.text,
    type: form.resource.type,
    is_private: is_private,
  }, {
    headers: {
      Authorization: Session.data.token
    }
  }).then((reponse) => {
    form.resource = reponse.data.result.Resource;
  }).catch(() => {
    form.errorMessage = 'Un problème est survenu lors de la sauvgarde, vérifiez votre connexion internet et réessayez.'
  })
}

function toggleAccessibility() {

  if (form.is_public) {
    router.push({ name: "record", params: { accessibility: 'private', id: form.resource.id } });
  } else {
    router.push({ name: "record", params: { accessibility: 'public', id: form.resource.id } });
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
  // alert('rediriger vers édition resource');
}

bus.on('changeOK', function () {
  saveResource();
})

bus.on('recordOK', function () {
  saveResource();
})



if (!route.params.id) {
  createResource();
} else {
  form.resource.id = route.params.id;
  console.log(form.resource.id);
  getResource()
}


function openEditResourceLive() {
  bus.emit('RecordDisplay')
}

function shareResource() {
  router.push({ name: "shareResourceById", params: { id: form.resource.id } })
}

</script>

<template>
  <MainFeed :TopAppBar="false">
    <!-- FORMULAIRE ÉDITION DE RESOURCE AVANT LE LIVE -->
    <form v-if="form.resource.type != 'stream'">
      <Card>
        <Title>Démarrer un enregistrement</Title>
        <Input name="title1" label="Titre" v-model:value="form.resource.title" />
        <Input name="text1" label="Description" v-model:value="form.resource.text" />
        <Text>
          <label for="role1" class="form-control">Partager publiquement</label>
          <input @click="toggleAccessibility" id="role1" name="role1" type="checkbox" v-model="form.is_public" />
        </Text>
      </Card>
    </form>
    <Card>
      <div class="shareGroup">
        <Button @click="shareResource">
          <div>
            <span>Partager dans mes groupes </span>
            <Icon>chevron_right</Icon>
          </div>
        </Button>
      </div>
    </Card>

    <!-- RETOUR LIVE -->
    <div id="recordDisplay"
      :class="{ recordOn: form.resource.type == 'stream', recordOff: form.resource.type != 'stream' }">
      <RecordDisplay v-if="form.resource.type == 'stream'" :id="form.resource.id" />
      <div id="liveButtons">
        <FloatingAppButton @click="openEditResourceLive" v-if="form.resource.type == 'stream'">
          <Icon>settings_photo_camera</Icon>
        </FloatingAppButton>
        <FloatingAppButton @click="startStopRecord">
          <Icon v-if="form.resource.type == 'text'">fiber_manual_record</Icon>
          <Icon v-if="form.resource.type == 'stream'">stop</Icon>
        </FloatingAppButton>
      </div>
    </div>
  </MainFeed>

  <!-- FORMULAIRE ÉDITION DE RESOURCE PENDANT LE LIVE -->
  <template v-if="form.resource.type == 'stream'">

    <ModalBottomSheet bus="RecordDisplay">
      <form>
        <Card>
          <Input name="title2" label="Titre" v-model:value="form.resource.title" />
          <Input name="text2" label="Description" v-model:value="form.resource.text" />
          <Text>
            <label for="role2" class="form-control">Partager publiquement</label>
            <input @click="toggleAccessibility" id="role2" name="role2" type="checkbox" v-model="form.is_public" />
          </Text>
          <Text v-if="form.errorMessage != ''">{{ form.errorMessage }}</Text>
          <div class="shareGroup">
            <Button @click="shareResource">
              <div>
                <span>Partager dans mes groupes </span>
                <Icon>chevron_right</Icon>
              </div>
            </Button>
          </div>
        </Card>
      </form>
    </ModalBottomSheet>
    <AsideFeed :large="true">
      <form>
        <Card>
          <Input name="title3" label="Titre" v-model:value="form.resource.title" />
          <Input name="text3" label="Description" v-model:value="form.resource.text" />
          <Text>
            <label for="role3" class="form-control">Partager publiquement</label>
            <input @click="toggleAccessibility" id="role3" name="role3" type="checkbox" v-model="form.is_public" />
          </Text>
          <Text v-if="form.errorMessage != ''">{{ form.errorMessage }}</Text>
          <div class="shareGroup">
            <Button @click="shareResource">
              <div>
                <span>Partager dans mes groupes </span>
                <Icon>chevron_right</Icon>
              </div>
            </Button>
          </div>
        </Card>
      </form>
    </AsideFeed>
  </template>
</template>
<style lang="scss" scoped>
@import "@/assets/scss/colors";
@import "@/assets/scss/media-queries";

.shareGroup {
  button {
    width: calc(100% - 1.5rem);

    div {
      width: 100%;
      display: flex;
      justify-content: space-between;
    }
  }
}

main {
  position: relative;
}

#recordDisplay.recordOn {
  position: relative;

  #liveButtons {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 0 .75rem;

    @media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $content-min-width + 24px)) {
      button:nth-child(1) {
        display: none;
        // display: none;
      }
    }

    button:nth-child(2) {
      position: absolute;
      left: 50%;
      bottom: 0;
      transform: translateX(calc(-50% - .75rem));
    }
  }
}

#recordDisplay.recordOff #liveButtons button {
  position: absolute;
  bottom: 4.25rem;
  left: 50%;
  transform: translateX(calc(-50% - .75rem));
}

// #liveButtons {
//   position: absolute;
//   bottom: 0;

//   &.recordOn button:nth-child(2) {
//     position: absolute;
//     bottom: 0;
//     left: .75rem;
//     width: calc(100% - 1.5rem);
//   }

//   &.recordOff button {
//     position: absolute;
//     left: calc(50% - .75rem);
//     transform: translateX(-50%);
//   }
// }


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