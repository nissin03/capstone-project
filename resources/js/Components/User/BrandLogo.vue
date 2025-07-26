<template>
    <img src="@/assets/cvsu_logo.png" :class="brandClass" alt="logo">
</template>

<script setup>
const props = defineProps({
    brandClass: {
        type: String,
        default: 'h-12',
    },
});
</script>
