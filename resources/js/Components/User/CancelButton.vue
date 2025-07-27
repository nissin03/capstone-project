<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    href: { type: String, required: true },
    label: { type: String, default: 'Cancel' },
    fullWidth: { type: Boolean, default: false },
})

const navigate = () => {
    router.visit(props.href)
}
</script>

<template>
    <button type="button" @click="navigate" :class="[
        'btn-secondary base-button-clr',
        fullWidth ? 'w-full' : ''
    ]">
        {{ label }}
    </button>
</template>
