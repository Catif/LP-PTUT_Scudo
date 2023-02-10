<script setup>
import ClickableCard from '@/components/ScudoTheming/ClickableCard.vue';
import Image from '@/components/ScudoTheming/Image.vue';
import Text from '@/components/ScudoTheming/Text.vue';
import AuthorSection from '@/components/AuthorSection.vue';

const props = defineProps(['resource', 'alt'])
</script>

<template>
    <Image :src="props['resource'].image" :alt="props['alt']"/>
</template>