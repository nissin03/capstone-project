<template>
    <nav class="text-xs text-stone-700 flex items-center gap-1 flex-wrap">
        <template v-for="(item, index) in items" :key="index">
            <span v-if="item.href && index !== items.length - 1">
                <Link :href="item.href" class="hover:underline text-stone-600">{{ item.label }}</Link>
            </span>
            <span v-else :class="index === items.length - 1 ? 'text-stone-400' : ''">
                {{ item.label }}
            </span>
            <span v-if="index !== items.length - 1">&gt;</span>
        </template>
    </nav>
</template>

<script setup>
defineProps({
    items: {
        type: Array,
        default: () => []
    }
})
</script>
