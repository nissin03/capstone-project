<script setup>
import { Search } from 'lucide-vue-next';

defineProps({
    placeholder: {
        type: String,
        default: 'Type here...',
    },
    size: {
        type: String,
        default: 'md', // 'sm', 'md', or 'lg'
    },
});

const inputClasses = {
    sm: 'text-sm pl-9 pr-3 py-1 placeholder:text-xs',
    md: 'text-base pl-10 pr-4 py-2',
    lg: 'text-lg pl-12 pr-5 py-3',
};

const iconClasses = {
    sm: 'size-4 left-2 top-1/2 -translate-y-1/2',
    md: 'size-5 left-2 top-1/2 -translate-y-1/2',
    lg: 'size-6 left-3 top-1/2 -translate-y-1/2',
};
</script>

<template>
    <div class="w-full mx-auto max-w-md">
        <form class="relative w-full">
            <Search class="absolute text-stone-700" :class="iconClasses[size]" />
            <input type="text" :placeholder="placeholder" class="input-default" :class="inputClasses[size]" />
        </form>
    </div>
</template>
