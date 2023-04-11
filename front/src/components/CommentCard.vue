<script setup>
import Username from "@/components/SmallUsername.vue";

import Card from "@/components/ScudoTheming/Card.vue";
import UserPicture from "@/components/UserPicture.vue";
import Text from "@/components/ScudoTheming/Text.vue";
import SmallText from "@/components/ScudoTheming/SmallText.vue";
import { inject, reactive } from "vue";
import { useSessionStore } from '@/stores/session.js';

const props = defineProps(['comment'])

const API = inject("api");
const Session = useSessionStore();
const datas = reactive({
    user: undefined
})

API.get(`/api/user/${props['comment'].id_user} `, {
    headers: {
        Authorization: Session.data.token,
    },
}).then((reponse) => {
    datas.user = reponse.data.result.user;
}).catch(() => {
    // alert('oups');
})




</script>

<template>
    <Card>
        <div class="content">
            <UserPicture :user="datas.user" />
            <section>
                <SmallText>
                    <Username v-if="typeof (datas.user) != 'undefined' && typeof (datas.user.username) != 'undefined'"
                        :user="datas.user">{{ datas.user.username }}
                    </Username>
                </SmallText>
                <Text>{{ props['comment'].text }}</Text>
            </section>
        </div>
    </Card>
</template>

<style lang="scss" scoped>
.content {
    display: flex;
    margin: 0.75rem;
}

a {
    height: 3rem;
    aspect-ratio: 1 / 1;
}

p {
    margin: 0px 0.75rem 0;
}

section {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
</style>