<template>
    <div class="relative w-full">
        <label class="text-[13px] text-stone-800">
            {{ name }}
        </label>
        <input :type="type" v-model="model" :class="[
            'floating-input',
            message ? 'border-red-500 focus:border-red-500' : ''
        ]" />
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
