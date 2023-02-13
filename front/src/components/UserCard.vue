<script setup>
import ProfilePicture from "./ProfilePicture.vue";
import ProfileStat from "./ScudoTheming/ProfileStat.vue";
import Alert from "./ScudoTheming/Alert.vue";
import FollowButton from "./ScudoTheming/FollowButton.vue";
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
      <ProfilePicture :src="user.image" :alt="'Photo de profil de ' + user.image" />
      <Alert class="live" v-if="live">LIVE</Alert>
    </main>
    <aside>
      <div class="stats">
        <ProfileStat :number="user.following" type="suivis" />
        <ProfileStat :number="user.followers" type="followers" />
      </div>
      <FollowButton />
    </aside>
    <Text class="biography">{{ user.biography }}</Text>
  </section>
</template>

<style lang="scss" scoped>
section {
  display: grid;
  grid-template-columns: 90px 1fr;
  grid-template-rows: auto;
  gap: 12px 42px;

  margin: 0px 12px;

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
