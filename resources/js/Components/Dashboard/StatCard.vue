<template>
    <div class="col-span-4 p-4 border border-stone-200 rounded-lg mt-2">
        <div class="flex items-start justify-between mb-8">
            <div>
                <h3 class="text-stone-500 mb-2 text-sm">
                    <slot />
                </h3>
                <p class="text-3xl font-semibold">&#8369;{{ amount?.toLocaleString() }}</p>
            </div>
            <span :class="[
                'text-[10px] flex items-center gap-1 px-2 rounded',
                percentageChange >= 0 ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100',
            ]">
                <component :is="percentageChange >= 0 ? TrendingUp : TrendingDown" class="w-4 h-4" />
                {{ percentageChange }}%
            </span>
        </div>
        <p class="text-xs text-stone-500">{{ date }}</p>
    </div>
</template>

<script setup>
import { TrendingDown, TrendingUp } from 'lucide-vue-next'

defineProps({
    amount: Number,
    percentageChange: Number,
    date: {
        type: String,
        default: '—',
    },
})
</script>
