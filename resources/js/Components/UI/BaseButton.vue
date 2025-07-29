<script setup>
import { ref } from 'vue'

const props = defineProps({
    icon: {
        type: [Object, Function],
        default: null,
    },
    type: {
        type: [Object, Function],
        default: null,
    },
})

const isHovered = ref(false)
</script>

<template>
    <Link href="#" @mouseenter="isHovered = true" @mouseleave="isHovered = false"
        class="inline-flex items-center gap-2 px-4 py-2 text-white rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">
    <component :is="icon" class="size-5 transform transition-transform duration-300"
        :class="{ 'rotate-360': isHovered }" />
    <slot />
    </Link>
</template>
