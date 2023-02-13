<script setup>
import Card from "./ScudoTheming/Card.vue";
import ProfileStat from "./UserStat.vue";
import FollowButton from "./ScudoTheming/FollowButton.vue";
import Text from "./ScudoTheming/Text.vue";
import Image from "./ScudoTheming/Image.vue";

const props = defineProps({
  group: {
    type: Object,
    required: true,
  }
});
</script>

<template>
  <Card>
    <Image :src="group.image" :alt="'Photo de couverture de' + props['group'].name" />
    <aside>
      <div class="stats">
        <ProfileStat :number="group.followers" type="followers" />
      </div>
      <FollowButton />
    </aside>
    <Text class="biography">{{ group.description }}</Text>
  </Card>
</template>

<style lang="scss" scoped>
img {
  aspect-ratio: 2 / 1;
}

aside {
  margin-top: 0.75rem;
  display: flex;

  .stats {
    padding: 0 1.5rem;
  }
}
</style>
