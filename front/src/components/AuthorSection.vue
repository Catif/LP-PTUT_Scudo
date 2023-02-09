<script setup>

import Username from "@/components/Username.vue";
import ProfilePicture from "@/components/ProfilePicture.vue";
import Title from "@/components/ScudoTheming/Title.vue";
import Text from "@/components/ScudoTheming/Text.vue";

const props = defineProps(['profile'])

</script>

<template>
    <section class="authorSection">
        <ProfilePicture :src="props['profile'].image" :alt="profile"/>
        <div>
            <Title>A la marche contre le climat !</Title>
            <Text><Username :to="props['profile'].pseudo">{{ props['profile'].pseudo }}</Username></Text>
        </div>
    </section>
</template>

<style lang="scss" scoped>
    section{
        display: flex;
        margin: 0.75rem;
    }
    img{
        height: 80px;
    }
</style>