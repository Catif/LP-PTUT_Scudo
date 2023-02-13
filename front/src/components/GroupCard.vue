<script setup>
import Card from '@/components/ScudoTheming/FilledCard.vue';
import Image from '@/components/ScudoTheming/Image.vue';
import Title from '@/components/ScudoTheming/Title.vue';
import Icon from '@/components/ScudoTheming/Icon.vue';

const props = defineProps(['group'])

</script>

<template>
    <Card>
        <Image :src="props['group'].image" :alt="'Photo de présentation de '+ props['group'].name"/>
        <section>
            <Title>
                {{ props['group'].name }}
            </Title>
            <Title>
                {{ props['group'].followers }}
                <Icon>
                group
                </Icon>
            </Title>
        </section> 
    </Card>
</template>

<style lang="scss" scoped>
 section{
    display: flex;
    justify-content: space-between;  
 }
</style>