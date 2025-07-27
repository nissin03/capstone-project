<template>
    <div class="relative">
        <button @click="toggle" class="hover:bg-stone-100 rounded p-2 cursor-pointer flex-center space-x-2">
            <span class="font-semibold">{{ firstName }}</span>
            <img :src="avatarUrl" alt="User Avatar" class="size-8 rounded-full object-cover border border-stone-300" />
        </button>
        <AccountDropdown v-if="!isAdminOrDir" :isOpen="isOpen" positionClass="absolute right-0 mt-2 w-40" />
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AccountDropdown from '../UI/AccountDropdown.vue';

const page = usePage()

const user = computed(() => page.props.auth.user)
const roles = computed(() => user.value?.roles || [])

const isAdminOrDir = computed(() => {
    return roles.value.includes('admin') || roles.value.includes('dir')
});


const firstName = computed(() => {
    return user.value?.name
        ? user.value.name.split(' ')[0]
        : '';
});

const avatarUrl = computed(() => {
    return user.value?.avatar
        ? `/storage/${user.value.avatar}`
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
