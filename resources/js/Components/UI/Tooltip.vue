<script setup>
import { onBeforeUnmount, ref } from 'vue'

const props = defineProps({
    content: {
        type: String,
        required: true,
    },
})

const isVisible = ref(false)
const position = ref({ x: 0, y: 0 })

function handleMouseMove(e) {
    position.value = {
        x: e.clientX + -62,
        y: e.clientY + -62,
    }
}

function handleMouseEnter() {
    isVisible.value = true
    window.addEventListener('mousemove', handleMouseMove)
}

function handleMouseLeave() {
    isVisible.value = false
    window.removeEventListener('mousemove', handleMouseMove)
}

onBeforeUnmount(() => {
    window.removeEventListener('mousemove', handleMouseMove)
})
</script>

<template>
    <span class="relative inline-flex" @mouseenter="handleMouseEnter" @mouseleave="handleMouseLeave">
        <slot />
    </span>

    <teleport to="body">
        <transition name="fade">
            <div v-if="isVisible"
                class="fixed z-50 px-3 py-2 text-xs text-white bg-black/90 rounded shadow-lg pointer-events-none transition-opacity duration-200"
                :style="`top: ${position.y}px; left: ${position.x}px`">
                {{ content }}
            </div>
        </transition>
    </teleport>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.15s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
