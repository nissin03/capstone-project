<script setup>

defineProps({
    type: {
        type: String,
        required: true
    },
    processing: {
        type: Boolean,
        default: false
    }
})
</script>
<template>
    <button :type="type" :disabled="processing" :class="[
        'btn-black',
        processing ? 'bg-black/70 opacity-75 cursor-not-allowed' : ''
    ]">
        <template v-if="processing">
            <div class="loader"></div>
        </template>
        <template v-else>
            <slot />
        </template>
    </button>
</template>
