<script setup>
import { LogOutIcon, UserIcon } from 'lucide-vue-next'

defineProps({
    isOpen: Boolean,
    positionClass: {
        type: String,
        default: 'absolute right-0 mt-2 w-40'
    }
})
</script>

<template>

    <div v-if="isOpen"
        :class="`${positionClass} bg-white rounded-md shadow-md z-50 divide-y divide-stone-200 transition-all`">

        <div class="p-3 flex items-center gap-2 hover:bg-stone-100 transition cursor-pointer">
            <Link href="#" class="flex items-center gap-2 w-full text-left">
            <UserIcon class="size-4 text-stone-500" />
            <span class="text-sm font-medium">Account</span>
            </Link>
        </div>

        <div class="p-3 hover:bg-red-100 transition cursor-pointer">
            <Link :href="route('logout')" method="post" as="button"
                class="flex items-center gap-2 text-red-600 w-full text-left">
            <LogOutIcon class="size-4 text-red-500" />
            <span class="text-sm font-medium">Logout</span>
            </Link>
        </div>
    </div>

</template>
