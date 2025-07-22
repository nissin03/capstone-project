<template>
    <div class="border-b px-4 mt-2 pb-4 border-stone-200">
        <div class="flex items-center justify-between p-0.5">
            <div class="text-start flex-1 min-w-0">
                <span class="text-sm font-medium block">
                    {{ greeting }}, {{ user }}
                </span>
                <span class="text-xs block text-stone-500 truncate">
                    {{ new Date().toLocaleDateString('en-US', {
                        weekday: 'long', year: 'numeric', month: 'long', day:
                            'numeric'
                    }) }}
                </span>
            </div>
            <BellNotification />
        </div>
    </div>
</template>

<script setup>
import { usePage, } from '@inertiajs/vue3';
import { computed } from 'vue';
import BellNotification from './BellNotification.vue';


const greeting = computed(() => {
    const hour = new Date().getHours();
    if (hour < 12) return 'Good morning';
    if (hour < 18) return 'Good afternoon';
    return 'Good evening';
});
const user = usePage().props.user;
</script
