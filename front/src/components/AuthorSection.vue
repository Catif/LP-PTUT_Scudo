<script setup>

import Username from "@/components/Username.vue";
import ProfilePicture from "@/components/ProfilePicture.vue";
import Title from "@/components/ScudoTheming/Title.vue";
import Text from "@/components/ScudoTheming/Text.vue";

const props = defineProps(['user', 'title'])

</script>

<template>
    <section class="authorSection">
        <ProfilePicture :src="props['user'].image" alt="profil"/>
        <div>
            <Title>{{ props['title'] }}</Title>
            <Text><Username :to="props['user'].username">{{ props['user'].username }}</Username></Text>
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