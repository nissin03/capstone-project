<template>
    <div class="text-center py-12">
        <div class="text-stone-400 mb-2">
            <component :is="icon" class="w-10 h-10 mx-auto rounded-full" />
        </div>
        <h3 class="text-lg font-medium text-stone-600 mb-2">{{ title }}</h3>
        <p class="text-stone-500 mb-4">
            {{ subtitle }}
        </p>
        <BaseButton v-if="$slots.default" :icon="Plus">
            <slot />
        </BaseButton>
    </div>
</template>

<script setup>
import BaseButton from '@components/BaseButton.vue'
import { Plus } from 'lucide-vue-next';

defineProps({
    icon: {
        type: [Object, Function],
        required: true,
    },
    type: {
        type: [Object, Function],
        default: null,
    },
    title: {
        type: String,
        default: 'Nothing found',
    },
    subtitle: {
        type: String,
        default: 'There is currently no content to show.',
    },
})
</script>
