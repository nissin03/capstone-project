<template>

    <div class="mt-10 flex justify-between items-center">
        <div>
            <template v-for="(link, index) in paginator.links" :key="index">
                <Link v-if="link.url" :href="link.url" v-html="link.label" preserve-scroll class="p-1 mx-1" :class="{
                    'text-green-500 font-medium': link.active
                }" />
                <span v-else v-html="link.label" class="p-1 mx-1 text-stone-300" />
            </template>
        </div>
        <p class="text-stone-600 text-sm">
            Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} results
        </p>
    </div>
</template>

<script setup>
defineProps({
    paginator: {
        type: Object,
        required: true,
    }
})
</script>
