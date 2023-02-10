<script setup>
import ProfilePicture from "./ProfilePicture.vue";
import ProfileStat from "./ScudoTheming/ProfileStat.vue";
import Alert from "./ScudoTheming/Alert.vue";
import FollowButton from "./FollowButton.vue";
import Text from "./ScudoTheming/Text.vue";

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
</script>

<template>
  <section>
    <main>
      <ProfilePicture :src="user.image" alt="Photo de profile" />
      <Alert class="live" v-if="live">LIVE</Alert>
    </main>
    <aside>
      <ProfileStat class="stat" :number="user.following" type="suivis" />
      <FollowButton />
    </aside>
    <Text class="biography">{{ user.biography }}</Text>
  </section>
</template>

<style lang="scss" scoped>
section {
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;

  gap: 12px;

  main {
    position: relative;
    height: fit-content;

    img {
      width: 100%;
      grid-column: 1 span;
    }

    .live {
      margin: 0;
      position: absolute;
      bottom: -5px;
      right: -12px;
    }
  }

  aside {
    padding: 12px;
    flex-grow: 1;
    display: flex;
    flex-direction: row;
    justify-content: space-between;

    .stat {
      flex-grow: 1;
    }
    .followButton {
      flex-grow: 1;
    }
  }

  .biography {
    padding: 0px 12px;
    margin: 12px 0;
    line-height: 1.5rem;

    grid-column: 2 span;
  }
}

@media screen and (min-width: 500px) {
  section {
    display: grid;
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
      gap: 12px 42px;

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
