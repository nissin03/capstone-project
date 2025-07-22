<template>
    <div class="grid grid-cols-[220px_1fr] gap-4 p-4 font-inter">
        <Sidebar />
        <div class="bg-white shadow min-h-dvh rounded-lg pb-2 w-full">
            <Header />
            <main class="flex flex-col flex-1 p-4">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from "../Components/Sidebar/Sidebar.vue";
import Header from "../Components/Dashboard/Header.vue";
</script>
