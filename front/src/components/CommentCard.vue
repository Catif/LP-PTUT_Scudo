<script setup>
import Username from "@/components/Username.vue";
import ProfilePicture from "@/components/ProfilePicture.vue";
import Text from "@/components/ScudoTheming/Text.vue";

const props = defineProps(['user', 'comment'])

</script>

<template>
        <section>
        <ProfilePicture :src="props['user'].image" alt="profil"/>
        <div>
            <Text><Username :to="props['user'].username">{{ props['user'].username }}</Username></Text>
            <Text>{{ props['comment'] }}</Text>
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