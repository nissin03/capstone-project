<template>
    <Link href="#" @click.prevent="handleClick" as="button" type="button"
        class="flex-center space-x-2  cursor-pointer p-2 border border-stone-300 hover:bg-stone-50 transition w-full rounded-md">
    <img src="@/assets/google-icon.svg" alt="Google Icon" class="size-4" loading="lazy">
    <p class="font-semibold text-stone-900">Google</p>
    </Link>
</template>

<script setup>
const emit = defineEmits(['google-login'])

const handleClick = () => {
    emit('google-login');
}
</script>
