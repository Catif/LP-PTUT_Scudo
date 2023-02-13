<script setup>
import Username from "@/components/SmallUsername.vue";

import Card from "@/components/ScudoTheming/Card.vue";
import ProfilePicture from "@/components/ProfilePicture.vue";
import Text from "@/components/ScudoTheming/Text.vue";
import SmallText from "@/components/ScudoTheming/SmallText.vue";
const props = defineProps(['user', 'comment'])

</script>

<template>
    <Card>
        <div class="content">
        <ProfilePicture :src="props['user'].image" alt="profil"/>
        <section>
            <SmallText><Username :to="props['user'].username">{{ props['user'].username }}</Username></SmallText>
            <Text>{{ props['comment'] }}</Text>
        </section>
        </div>
    </Card>
</template>

<style lang="scss" scoped>

    .content{
        display: flex;
        margin: 0.75rem;
    }
    img{
        height: 3rem;
    }
    p{
        margin: 0px 0.75rem 0;
    }
    section{
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
</style>