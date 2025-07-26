<script setup>
import { Menu, ShoppingCart, X, User } from 'lucide-vue-next';
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
import SearchInput from '../UI/SearchInput.vue';
import NavbarLinks from './NavbarLinks.vue';
import UserDropdown from './UserDropdown.vue';
import { usePage } from '@inertiajs/vue3';
import BrandLogo from './BrandLogo.vue';

const isOpen = ref(false);
const sidebarRef = ref(null);

function handleClickOutside(e) {
    if (isOpen.value && sidebarRef.value && !sidebarRef.value.contains(e.target)) {
        isOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('mousedown', handleClickOutside);
});

const cartCount = ref(10);

</script>
<template>
    <header class="sticky top-0 z-50 bg-white shadow">
        <div class="flex-items justify-between px-5 py-4 max-w-7xl mx-auto">
            <div>
                <Link href="/">
                <BrandLogo />
                </Link>
            </div>

            <SearchInput class="hidden md:block" />
            <div class="flex-items justify-end gap-4">
                <Link href="/cart" class="relative hover:bg-stone-100 rounded-full p-2 inline-block">
                <ShoppingCart class="size-5 text-stone-800" />
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-semibold rounded-full
         min-w-[18px] h-[18px] flex-items justify-center shadow aspect-square">
                    {{ cartCount }}
                </span>
                </Link>

                <div v-if="$page.props.auth.user" class="flex items-center gap-2">
                    <UserDropdown />
                </div>
                <Link v-else :href="route('login.index')"
                    class="hover:bg-stone-100 rounded p-2 cursor-pointer flex-center space-x-1">
                <span class="font-semibold">Login</span>
                </Link>
                <!-- Mobile toggle  -->
                <div class="md:hidden">
                    <Menu @click="isOpen = !isOpen" />
                </div>
            </div>
        </div>
        <nav>
            <NavbarLinks class="hidden md:flex" :vertical="false" size="base" />
        </nav>
    </header>
    <!-- Mobile modal sidebar  -->
    <transition enter-active-class="transition transform ease-out duration-300" enter-from-class="translate-x-full"
        enter-to-class="translate-x-0" leave-active-class="transition transform ease-in duration-200"
        leave-from-class="translate-x-0" leave-to-class="translate-x-full">
        <teleport to="body">
            <div ref="sidebarRef" v-if="isOpen"
                class="md:hidden  fixed top-0 right-0 z-50 w-64 h-100 p-4 bg-white rounded-lg shadow-lg">
                <div class=" w-full flex-items justify-end cursor-pointer">
                    <button @click="isOpen = false"
                        class="bg-gray-100 p-2 rounded hover:bg-gray-200 transition-colors duration-400">
                        <X />
                    </button>
                </div>
                <SearchInput class="mt-4" size="md" placeholder="Search here..." />
                <NavbarLinks class="mt-6" :vertical="true" size="xl" />
            </div>
        </teleport>
    </transition>

</template>
