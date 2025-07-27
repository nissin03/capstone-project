<template>
    <Link href="#" as="button" type="button"
        class="base-button-clr btn-secondary w-full flex items-center gap-2 justify-center"
        @click.prevent="handleClick">
    <img src="@/assets/google-icon.svg" alt="Google Icon" class="size-4" loading="lazy" />
    <span class="font-semibold text-stone-900">Google</span>
    </Link>
</template>

<script setup>
const emit = defineEmits(['google-login'])

const handleClick = () => {
    emit('google-login')
}
</script>
