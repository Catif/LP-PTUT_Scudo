<script setup>
import Input from "../components/ScudoTheming/Input.vue";
import Title from "../components/ScudoTheming/Title.vue";
import TextArea from "../components/ScudoTheming/Textarea.vue";
import MainFeed from "../components/ScudoTheming/MainFeed.vue";
import Button from "../components/ScudoTheming/FilledButton.vue";
import Alert from "../components/ScudoTheming/Alert.vue";
import Card from "../components/ScudoTheming/Card.vue";
import { reactive, ref, inject } from "vue";
import { useSessionStore } from "@/stores/session.js";
import { useRoute, useRouter } from "vue-router";

const form = reactive({
  image: "",
  biography: "",
  username: "",
});
const route = useRoute();
const router = useRouter();
const API = inject("api");
const Session = useSessionStore();
const user = reactive({});
const message = ref("");

API.get(`/api/user/${route.params.id}`, {
  headers: {
    Authorization: Session.data.token,
  },
})
  .then((result) => {
    message.value = "";
    user.value = result.data.result.user;
    form.biography = result.data.result.user.biography;
    form.username = result.data.result.user.username;
  })
  .catch((error) => {
    message.value = error.response.data.error;
  });

function isValidForm() {
  if (form.image) {
    let fileData = new FormData();
    fileData.append("file", form.image);
    let config = {
      headers: {
        "Content-Type": "multipart/form-data",
        Authorization: Session.data.token,
      },
    };
    API.post("/api/upload", fileData, config)
      .then((result) => {
        let url = result.data.result.url;

        API.post(
          "/api/user/edit",
          {
            username: form.username,
            biography: form.biography,
            image: url,
          },
          config
        )
          .then((response) => {
            router.push(`/profile/${user.value.id}`);
          })
          .catch((error) => {
            message.value = error.response.data.error;
          });
      })
      .catch((error) => {
        message.value = error.response.data.error;
      });
  } else {
    API.post(
      "/api/user/edit",
      {
        username: form.username,
        biography: form.biography,
      },
      {
        headers: {
          Authorization: Session.data.token,
        },
      }
    )
      .then((response) => {
        router.push(`/profile/${user.value.id}`);
      })
      .catch((error) => {
        message.value = error.response.data.error;
      });
  }
}
</script>

<template>
  <MainFeed>
    <Card>
      <Alert v-if="message" class="error">{{ message }}</Alert>
      <p>{{ form.image }}</p>
      <Title>Modifier votre profil !</Title>
      <form @submit.prevent="isValidForm">
        <Input type="file" name="image" label="Photo" accept=".jpg, .jpeg, .png" v-model:value="form.image" />
        <TextArea name="biography" label="Biographie" v-model:value="form.biography" />
        <Input name="username" label="Pseudo" v-model:value="form.username" />
        <Button>Modifier mon profil</Button>
      </form>
    </Card>
  </MainFeed>
</template>

<style lang="scss" scoped>
button {
  width: 100%;
  text-align: center;
  margin-left: 0;
}

.error {
  width: 100%;
  text-align: center;
}
</style>
