<script setup>
import Image from '@/components/ScudoTheming/Image.vue';
import Alert from '@/components/ScudoTheming/Alert.vue';

const props = defineProps(['resource', 'alt'])
</script>

<template>
    <div class="resourceSection">
        <Alert>LIVE</Alert>
        <Image :src="props['resource'].image" :alt="props['alt']" />
    </div>
</template>

<style lang="scss" scoped>
.resourceSection {
    position: relative;

    div {
        position: absolute;
        top: 0;
        left: 0;
    }
}
</style>