<script setup>
const props = defineProps({
    href: String,
    icon: [Object, Function],
    type: {
        type: String,
        default: 'button'
    },
})
const emits = defineEmits(['click'])
</script>
<template>

    <Link v-if="href" :href="href"
        class="actions-style  hover:text-green-600 hover:bg-green-50 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">
    <component :is="icon" class="size-4" />
    </Link>

    <button v-else :type="type" @click="$emit('click')"
        class="actions-style cursor-pointer hover:text-red-600 hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
        <component :is="icon" class="size-4" />
    </button>
</template>
