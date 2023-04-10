<script setup>
import Card from "./ScudoTheming/Card.vue";
import UserPicture from "./UserPicture.vue";
import UserStat from "./UserStat.vue";
import Alert from "./ScudoTheming/Alert.vue";
import FollowButton from "./ScudoTheming/FollowButton.vue";
import Text from "./ScudoTheming/Text.vue";
import { useSessionStore } from "@/stores/session.js";
import { useRoute } from "vue-router";
import { ref } from "vue";

const route = useRoute();
const Session = useSessionStore();

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  live: {
    type: Boolean,
    default: false,
  },
});

console.log(props.user);

const edit = ref(false);

console.log(Session.data.idUser, route.params.id);
if (Session.data.idUser === route.params.id) {
  edit.value = true;
}

console.log(props.user.follows);
</script>

<template>
  <Card>
    <section>
      <main>
        <UserPicture :user="user" />
        <Alert class="live" v-if="live">LIVE</Alert>
      </main>
      <aside>
        <div class="stats">
          <UserStat :number="user.following" type="suivis" />
          <UserStat :number="user.followers" type="followers" />
        </div>
        <FollowButton type="user" :id="user.id" />
      </aside>
      <Text class="biography">{{ user.biography }}</Text>
    </section>
  </Card>
</template>

<style lang="scss" scoped>
section {
  display: grid;
  grid-template-columns: 90px 1fr;
  grid-template-rows: auto;
  gap: 12px 42px;

  padding: 12px;

  main {
    position: relative;
    height: fit-content;

    img {
      width: 90px;
      height: 90px;
    }

    .live {
      margin: 0;
      position: absolute;
      bottom: -5px;
      right: -17px;
    }
  }

  aside {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    .stats {
      display: flex;
      justify-content: space-evenly;
    }
  }

  .biography {
    margin: 12px 0;
    line-height: 1.5rem;

    grid-column: 2 span;
  }
}

@media screen and (min-width: 500px) {
  section {
    grid-template-columns: 175px 1fr;

    main {
      img {
        width: 175px;
        height: 175px;
      }
    }

    aside {
      display: grid;
      grid-template-columns: 175px 1fr;
      grid-column: 2 span;
      // gap: 12px;

      .stats {
        grid-column: 1 span;
      }

      .follow {
        grid-column: 1 span;
      }
    }

    .biography {
      grid-row: 1;
      grid-column: 2/3;
    }
  }
}
</style>
