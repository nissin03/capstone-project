<template>
    <label class="flex items-center space-x-2 cursor-pointer">
        <input type="checkbox" class="peer sr-only" :checked="checked" @change="checked = $event.target.checked" />
        <div class="size-5 rounded-full border-2 border-stone-300 bg-white
             peer-checked:bg-green-600 peer-checked:border-green-600
             flex items-center justify-center transition-colors duration-200">
            <Check
                class="size-4 text-white scale-75 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200" />

        </div>
        <span class="text-sm text-stone-700">
            {{ label }}
        </span>
    </label>
</template>

<script setup>
import { Check } from 'lucide-vue-next'
const checked = defineModel()
const props = defineProps({
    label: String,
})
</script>
