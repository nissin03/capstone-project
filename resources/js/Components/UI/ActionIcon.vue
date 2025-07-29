<script setup>
const props = defineProps({
    href: String,
    icon: [Object, Function],
    type: {
        type: String,
        default: 'button'
    },
    class: {
        type: [String, Array, Object],
        default: ''
    }
})
const emits = defineEmits(['click'])
</script>
<template>

    <Link v-if="href" :href="href" class="actions-style  transition-colors">
    <component :is="icon" class="size-4" :class="props.class" />
    </Link>

    <button v-else :type="type" @click="$emit('click')" class="actions-style cursor-pointer  transition-colors">
        <component :is="icon" class="size-4" :class="props.class" />
    </button>
</template>
