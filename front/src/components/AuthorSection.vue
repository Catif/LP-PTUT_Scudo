<script setup>

import Username from "@/components/Username.vue";
import UserPicture from "@/components/UserPicture.vue";
import Title from "@/components/ScudoTheming/Title.vue";
import Text from "@/components/ScudoTheming/Text.vue";
import { processSlotOutlet } from "@vue/compiler-core";

const props = defineProps(['user', 'title'])

</script>

<template>
    <section class="authorSection">
        <UserPicture :user="props['user']" />
        <div>
            <Title>{{ props['title'] }}</Title>
            <Text>
                <Username :user="user">{{ props['user'].username }}</Username>
            </Text>
        </div>
    </section>
</template>

<style lang="scss" scoped>
section {
    display: flex;
    margin: 0.75rem;
}

a {
    width: 3.5rem;
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