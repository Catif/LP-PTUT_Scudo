<script setup>
import ClickableFilledCard from '@/components/ScudoTheming/ClickableFilledCard.vue';
import Text from '@/components/ScudoTheming/Text.vue';
import AuthorSection from '@/components/AuthorSection.vue';
import ResourceSection from '@/components/ResourceSection.vue';
import Icon from '@/components/ScudoTheming/Icon.vue';

const props = defineProps(['user', 'resource', 'group'])
</script>

<template>
    <ClickableFilledCard>
            <Text v-if="props['group']"><Icon>groups</Icon> {{ props['group'].name }}</Text>
        <ResourceSection :resource="props['resource']" :alt="'Vidéo' + props['resource'].title + 'de ' + props['user'].username" />
        <AuthorSection :user="props['user']" :title="props['resource'].title" />
        <Text>
            {{ props['resource'].description }}
        </Text>
    </ClickableFilledCard>
</template>
<style lang="scss" scoped>

</style>