<script setup>
import Icon from '@/components/ScudoTheming/Icon.vue';
import Text from '@/components/ScudoTheming/Text.vue';
import {ref} from "vue";

const props = defineProps(['description'])

var descriptionHidden = ref(true)
function toggle(){
    this.descriptionHidden = !this.descriptionHidden
}
</script>

<template>
<div>
    <button :class="{ hidden: !descriptionHidden }" @click="toggle()">
            <Text class="flex"><div class="text">{{ props['description'] }}</div><Icon>chevron_right</Icon></Text>
    </button>
        <div :class="{ hidden: descriptionHidden }">
            <Text>{{ props['description'] }}</Text>
        </div>
</div>
</template>

<style lang="scss" scoped>
    @import "@/assets/scss/media-queries";
    @import "@/assets/scss/colors";

    button{
        width: 100%; // a changer plus tard (Mettre 100% pour la card)
        border: none;
        white-space:nowrap;
        background-color: transparent;
        cursor: pointer;
        padding: 0;
        color: $neutral-color-10;
        .text{
            overflow:hidden; 
            white-space:nowrap; 
            text-overflow: ellipsis;
        }
        .flex{
            display: flex;
        }
    }

    .hidden{
        display: none;
    }

    @media screen and (min-width : calc($navigation-bar-min-width + $content-min-width + $aside-bar-min-width)) {
        button, button.hidden {
            display: none;
        }
        .hidden{
            display: block;
        }
    }
</style>