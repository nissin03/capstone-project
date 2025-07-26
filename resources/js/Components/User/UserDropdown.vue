<template>
    <div class="relative">
        <button @click="toggle" class="hover:bg-stone-100 rounded p-2 cursor-pointer flex-center space-x-2">
            <span class="font-semibold">{{ firstName }}</span>
            <img :src="avatarUrl" alt="User Avatar" class="size-8 rounded-full object-cover border border-stone-300" />
        </button>

        <div v-show="isOpen"
            class="absolute right-0 mt-2 w-40 bg-white border border-stone-200 rounded-md shadow-lg transition-all duration-200 z-50"
            ref="dropdown">
            <div class="py-2 text-sm text-gray-700 divide-y divide-stone-200">
                <Link href="/account" class="flex items-center gap-2 px-4 py-2 hover:bg-green-100">
                <User class="size-4" />
                Account
                </Link>

                <Link :href="route('logout')" method="post" as="button"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-red-100 hover:text-red-700 w-full text-left cursor-pointer">
                <LogOut class="size-4" />
                Logout
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { User, LogOut } from 'lucide-vue-next'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const firstName = computed(() => {
    return page.props.auth.user?.name
        ? page.props.auth.user.name.split(' ')[0]
        : '';
});


const avatarUrl = computed(() => {
    const user = page.props.auth.user;
    return user?.avatar
        ? `/storage/${user.avatar}`
        : 'https://placehold.co/200x200';
});
const isOpen = ref(false)
const dropdown = ref(null)

const toggle = () => {
    isOpen.value = !isOpen.value
}

const handleClickOutside = (e) => {
    if (isOpen.value && dropdown.value && !dropdown.value.contains(e.target)) {
        isOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside)
})
onBeforeUnmount(() => {
    document.removeEventListener('mousedown', handleClickOutside)
})
</script>
