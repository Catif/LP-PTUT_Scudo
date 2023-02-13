<script setup>

import Username from "@/components/Username.vue";
import ProfilePicture from "@/components/ProfilePicture.vue";
import Title from "@/components/ScudoTheming/Title.vue";
import Text from "@/components/ScudoTheming/Text.vue";

const props = defineProps(['user', 'title'])

</script>

<template>
    <section class="authorSection">
        <ProfilePicture :user="props['user']" />
        <div>
            <Title>{{ props['title'] }}</Title>
            <Text>
                <Username :to="'/user/' + props['user']">{{ props['user'].username }}</Username>
            </Text>
        </div>
    </section>
</template>

<style lang="scss" scoped>
section {
    display: flex;
    margin: 0.75rem;
}

img {
    height: 3.5rem;
}

h2,
p {
    margin: 0px 0.75rem 0;
}

div {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
</style>