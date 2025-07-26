<script setup>
import { computed } from 'vue';
import NavLink from './NavLink.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    vertical: {
        type: Boolean,
        default: false,
    },
    size: {
        type: String,
        default: 'base',
    },
});

const page = usePage();

const linkClass = computed(() => {
    return props.vertical
        ? `flex flex-col items-start justify-start space-y-4 py-3 text-${props.size}`
        : `flex items-center justify-center space-x-5 py-3 text-${props.size}`;
});
</script>

<template>
    <div :class="linkClass">
        <NavLink href="/" :active="$page.component === 'Home'">Home</NavLink>
        <NavLink href="/facilities" :active="$page.component === 'Shop'">Shop</NavLink>
        <NavLink href="/facilities" :active="$page.component === 'Facilities'">Facilities</NavLink>
        <NavLink href="/about-us" :active="$page.component === 'About'">About Us</NavLink>
        <NavLink href="/contact-us" :active="$page.component === 'Contact'">Contact</NavLink>
    </div>
</template>
