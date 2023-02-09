<script setup>
import ClickableCard from '@/components/ScudoTheming/ClickableFilledCard.vue';
import Image from '@/components/ScudoTheming/Image.vue';
import Text from '@/components/ScudoTheming/Text.vue';
import AuthorSection from '@/components/AuthorSection.vue';
import ResourceSection from '@/components/ResourceSection.vue';
const props = defineProps(['user', 'title', 'src', 'alt', 'resource'])
</script>

<template>
    <ClickableFilledCard>
        <ResourceSection :src="props['resource'].image" :alt="props['alt']"/>
        <AuthorSection :user="props['user']" :title="props['resource'].title"/>
        <Text>
            {{ props['resource'].description }}
        </Text>
    </ClickableFilledCard>
</template>

<style lang="scss" scoped>

</style>