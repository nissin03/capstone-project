<template>
    <div class="relative w-full">
        <input :type="type" placeholder=" " v-model="model" :class="[
            'peer floating-input',
            message ? 'border-red-500 focus:border-red-500' : ''
        ]" />
        <label class="floating-label transition-all duration-200" :class="[
            (model || message) ? '-top-2 text-xs text-stone-800' : ''
        ]">
            {{ name }}
        </label>
        <small class="text-red-500" v-if="message">{{ message }}</small>
    </div>
</template>

<script setup>
const model = defineModel({
    type: null,
    required: true,
});

defineProps({
    type: {
        type: String,
        required: true
    },
    name: {
        type: String,
        required: true
    },
    message: String,
});
</script>
