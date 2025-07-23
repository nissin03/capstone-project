<template>
    <div @click="isOpen = !isOpen" class="border-b mb-4 pb-4 mt-2 border-stone-300 relative">
        <button class="p-0.5 flex items-center gap-2 w-full
         transition-colors hover:bg-stone-300
         relative rounded cursor-pointer">
            <Link :href="route('admin.dashboard')" class="rounded bg-green-500 shadow">
            <img src="https://api.dicebear.com/9.x/pixel-art/svg" alt="" class="size-8 shrink-0 ">
            </Link>
            <div class="text-start flex-1 min-w-0">
                <span class="font-medium block text-sm">{{ user }}</span>
                <span class="block text-xs text-stone-500 truncate">estrellajohnrobin25@gmail.com</span>
            </div>
            <ChevronsUpDown class="ml-auto shrink-0 size-4 text-stone-500" />
        </button>
        <teleport to="body">
            <div v-if="isOpen"
                class="absolute bg-white rounded-md shadow-md z-50 divide-y divide-stone-200 top-10 left-[220px] cursor-pointer">
                <div class="p-3 flex items-center gap-2 hover:bg-stone-100 transition">
                    <UserIcon class="size-4 text-stone-500" />
                    <span class="text-sm font-medium">Account</span>
                </div>

                <div class="p-3 flex items-center gap-2 hover:bg-stone-100 transition">
                    <LogOutIcon class="size-4 text-red-500" />
                    <span class="text-sm font-medium text-red-600">Logout</span>
                </div>
            </div>
        </teleport>
    </div>

</template>

<script setup>
import { ChevronsUpDown, UserIcon, LogOutIcon } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
import { Teleport, ref } from 'vue';

const user = usePage().props.user;
const isOpen = ref(false);

</script>
