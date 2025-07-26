<template>
    <div class="font-pops min-h-dvh bg-white flex flex-col">
        <Header />
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <slot />
            </div>
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Header from '../Components/User/Header.vue';
import Footer from '../Components/User/Footer.vue'

</script>
