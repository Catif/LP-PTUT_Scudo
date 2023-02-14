<script setup>
import Image from '@/components/ScudoTheming/Image.vue';
import Alert from '@/components/ScudoTheming/Alert.vue';

const props = defineProps(['resource', 'user'])

var alt = '';
if(props['resource'].type === 'live'){
    alt = 'Live de ' + props['user'].username;
}else{
    alt = 'Vidéo de ' + props['user'].username;
}
</script>

<template>
    <div class="resourceSection">
        <Alert v-if="props['resource'].type === 'live'">LIVE</Alert>
        <Image :src="props['resource'].image" :alt="alt" />
    </div>
</template>

<style lang="scss" scoped>
.resourceSection {
    position: relative;
    z-index: 1;

    div {
        position: absolute;
        top: 0;
        left: 0;
    }
}

//Passer le user à la place du alt partout ou on utilise ResourceSection 
</style>