<script setup>
import AccountToggle from './AccountToggle.vue';
import Search from './Search.vue'
import SidebarMenu from './SidebarMenu.vue';
import { menuItems } from '@/navigation/menuItems.js'
import { inject } from 'vue';

const sidebarOpen = inject('sidebarOpen')
</script>

<template>
    <aside class="sticky top-4 overflow-y-scroll h-[calc(100vh-32px-48px)]">
        <AccountToggle />
        <Search />
        <SidebarMenu :menuItems="menuItems" :sidebar-open="sidebarOpen" />
    </aside>
</template>
