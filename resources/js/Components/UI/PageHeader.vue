<template>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h2 class="text-xl font-semibold text-stone-800">{{ title }}</h2>
        <slot name="breadcrumbs" />
    </div>
</template>


<script setup>
defineProps({
    title: {
        type: String,
        required: true
    }
})
</script>
