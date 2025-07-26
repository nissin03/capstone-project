<script setup>
defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <Link :href="href" class="group">
    <span :class="[
        'relative text-sm font-semibold',
        'before:absolute before:-bottom-1 before:left-0',
        'before:h-0.5 before:bg-green-500',
        'before:transition-all before:duration-300',
        active ? 'before:w-full' : 'before:w-0 group-hover:before:w-full'
    ]">
        <slot />
    </span>
    </Link>
</template>
