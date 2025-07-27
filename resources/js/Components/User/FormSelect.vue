<template>
    <div class="relative w-full">
        <label class="text-[13px] text-stone-800">
            {{ name }}
        </label>
        <select v-model="model" class="peer floating-input appearance-none"
            :class="message ? 'border-red-500 focus:border-red-500' : ''" :disabled="disabled">
            <option v-if="!model" :value="null" disabled selected></option>
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.label }}
            </option>
        </select>

        <small class="text-red-500" v-if="message">{{ message }}</small>
    </div>
</template>

<script setup>
const model = defineModel({ required: true })

defineProps({
    name: {
        type: String,
        required: true
    },
    options: {
        type: Array,
        default: () => []
    },
    message: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    }
})
</script>
