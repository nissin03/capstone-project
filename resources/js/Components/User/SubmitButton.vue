<script setup>
import PulseLoader from './PulseLoader.vue';

defineProps({
    type: { type: String, required: true },
    processing: { type: Boolean, default: false },
    fullWidth: { type: Boolean, default: false },
})

</script>

<template>
    <button :type="type" :disabled="processing" :class="[
        'btn-primary base-button-clr',
        fullWidth ? 'w-full' : '',
        processing ? 'bg-black/70 opacity-75 cursor-not-allowed' : ''
    ]">
        <template v-if="processing">
            <PulseLoader />
        </template>
        <template v-else>
            <slot />
        </template>
    </button>
</template>
