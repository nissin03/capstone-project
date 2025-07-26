<script setup>
import NavbarLinks from './NavbarLinks.vue';
import { ref } from 'vue';

const date = ref(new Date().getFullYear());
</script>

<template>
    <footer class="border-t border-stone-200 mt-12 py-8 bg-white text-neutral-700 text-sm">
        <div class="container mx-auto px-4 flex flex-col items-center gap-4 sm:gap-6">
            <div class="w-full sm:w-auto">
                <NavbarLinks :vertical="true" size="sm" class="sm:hidden" />
                <NavbarLinks :vertical="false" size="sm" class="hidden sm:flex" />
            </div>
            <div class="text-xs text-neutral-500 text-center">
                &copy; {{ date }} CvSU BaRG. All rights reserved.
            </div>
        </div>
    </footer>
</template>
