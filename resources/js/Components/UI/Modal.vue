<script setup>
defineProps({
    show: {
        type: Boolean,
        default: false,
    }
})
</script>

<template>

    <teleport to='body'>
        <div class="fixed inset-0  size-full items-center justify-center flex">
            <div class=" bg-black/75 fixed inset-0 z-40 size-full"></div>
            <div class="z-50 w-full max-w-md rounded-lg bg-white p-4">
                <slot />
            </div>
        </div>
    </teleport>

</template>
