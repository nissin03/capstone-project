<template>
    <div :class="[
        'grid gap-4 p-4 font-inter',
        sidebarOpen ? 'grid-cols-[220px_1fr]' : 'grid-cols-[1fr]'
    ]">

        <Sidebar v-show="sidebarOpen" />
        <div class="bg-white shadow min-h-dvh rounded-lg pb-2 w-full">
            <Header @toggle-sidebar="sidebarOpen = !sidebarOpen" />
            <main class="flex flex-col flex-1 p-4">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from "../Components/Sidebar/Sidebar.vue";
import Header from "../Components/Dashboard/Header.vue";
import { ref, watch, provide } from "vue";

const storedSidebarState = localStorage.getItem("sidebarOpen");
const sidebarOpen = ref(storedSidebarState !== null ? storedSidebarState === "true" : true);
provide('sidebarOpen', sidebarOpen)

watch(sidebarOpen, (newState) => {
    localStorage.setItem("sidebarOpen", newState)
});

</script>
