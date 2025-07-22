<template>
    <div class="border-b mb-4 pb-4 mt-2 border-stone-300">
        <button class="p-0.5 flex items-center gap-2 w-full
         transition-colors hover:bg-stone-300
         relative rounded">
            <Link :href="route('admin.dashboard')" class="rounded bg-green-500 shadow">
            <img src="https://api.dicebear.com/9.x/pixel-art/svg" alt="" class="size-8 shrink-0 ">
            </Link>
            <div class="text-start flex-1 min-w-0">
                <span class="font-medium block text-sm">{{ user }}</span>
                <span class="block text-xs text-stone-500 truncate">estrellajohnrobin25@gmail.com</span>
            </div>
            <ChevronsUpDown class="ml-auto shrink-0 size-4 text-stone-500" />
        </button>
    </div>
</template>

<script setup>
import { ChevronsUpDown } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';

const user = usePage().props.user;
</script>
