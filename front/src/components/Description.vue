<script setup>
import Icon from '@/components/ScudoTheming/Icon.vue';
import Text from '@/components/ScudoTheming/Text.vue';
import {ref} from "vue";

const props = defineProps(['description'])

var descriptionHidden = ref(false)
function toggle(){
    this.descriptionHidden = !this.descriptionHidden
}
</script>

<template>
<div>
    <template v-if="!descriptionHidden">
    <button @click="toggle()">
            <Text class="flex"><div class="text">{{ props['description'] }}</div><Icon>chevron_right</Icon></Text>
    </button>
    </template>
    <template v-else>
        <div>
            <Text>{{ props['description'] }}</Text>
        </div>
    </template>
</div>
</template>

<style lang="scss" scoped>
    button{
        width: 500px; // a changer plus tard (Mettre 100% pour la card)
        border: none;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        white-space:nowrap;
        cursor: pointer;
        .text{
            overflow:hidden; 
            white-space:nowrap; 
            text-overflow: ellipsis;
        }
        .flex{
            display: flex;
        }
    }
</style>