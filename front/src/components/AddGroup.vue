<script setup>
import { reactive, inject } from 'vue';
import { useSessionStore } from '@/stores/session.js';
import Text from './ScudoTheming/Text.vue';


const API = inject("api");
const props = defineProps(['group', 'resource'])
const Session = useSessionStore();

var form = reactive({
  group: {}
});

form.group = props.group;
if (form.group.shared != true) {
  form.group.shared = false;
}


function addShare() {
  API.post(`/api/resource/${props.resource.id}/group/${form.group.id}`,
    {}, {
    headers: {
      Authorization: Session.data.token,
    },
  }).catch((e) => {
    form.group.shared = !form.group.shared
  })
}

function removeShare() {
  API.delete(`/api/resource/${props.resource.id}/group/${form.group.id}`,
    {
      headers: {
        Authorization: Session.data.token,
      },
    }).catch((e) => {
      form.group.shared = !form.group.shared
    })
}

function updateShare() {
  form.group.shared = !form.group.shared
  if (form.group.shared) {
    addShare();
  } else {
    removeShare();
  }
}

</script>

<template>
  <div>
    <form>
      <Text>
        <input :id="props['group'].name" :name="props['group'].name" type="checkbox" @click="updateShare"
          v-model="form.group.shared">
        <label :for="props['group'].name" class="form-control">
          &nbsp;{{ props['group'].name }}
        </label>
      </Text>
    </form>
  </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/colors";

* {
  box-sizing: border-box;

  &::before,
  &::after {
    box-sizing: border-box;
  }
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
    content: '';
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