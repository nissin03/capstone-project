<script setup>
import BrandLogo from './BrandLogo.vue';

defineProps({
    title: String,
})
</script>

<template>
    <div class="flex flex-col justify-center px-6 py-9 sm:mx-auto sm:w-full sm:max-w-md lg:px-8">

        <Head :title="title" />
        <div class="mx-auto w-full">
            <div class="flex-center">
                <BrandLogo brandClass="h-20" />
            </div>
        </div>
        <h2 class=" text-center text-2xl font-semibold leading-9 tracking-tight">
            <slot name="heading" />
        </h2>
        <div class="relative mt-10 w-full">
            <slot />
        </div>
    </div>
</template>
