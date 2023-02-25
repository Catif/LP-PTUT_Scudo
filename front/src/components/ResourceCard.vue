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
        <RouterLink :to="'/group/' + group.id" v-if="group">
            <Text>
                <Icon>groups</Icon> {{ group.name }}
            </Text>
        </RouterLink>
        <ResourceSection :resource="resource" :user="user" />
        <AuthorSection :user="user" :title="resource.title" />
        <Text>
            {{ resource.text }}
        </Text>
    </ClickableFilledCard>
</template>
<style lang="scss" scoped>
a {
    text-decoration: none;

    p {
        margin: 0;
        padding: 0.75rem;
    }
}
</style>