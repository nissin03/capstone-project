<template>
    <div class="mt-4 flex justify-between items-center">
        <div class="rounded shadow">
            <template v-for="(link, index) in paginator.links" :key="index">
                <Link v-if="link.url" :href="link.url" v-html="makeLabel(link.label)" preserve-scroll preserve-state
                    class="p-1 mx-1" :class="{ 'text-green-500 font-medium': link.active }" />
                <span v-else v-html="makeLabel(link.label)" class="p-1 mx-1 text-stone-300" />
            </template>
        </div>
        <p class="text-stone-600 text-xs">
            Showing <strong>
                {{ paginator.from }}</strong> to <strong>
                {{ paginator.to }}</strong> of <strong>
                {{ paginator.total }}</strong> results
        </p>
    </div>
</template>

<script setup>
defineProps({
    paginator: {
        type: Object,
        required: true,
    },
})

const makeLabel = (label) => {
    if (label.includes("Previous")) {
        return "&laquo;"
    } else if (label.includes("Next")) {
        return "&raquo;"
    } else {
        return label
    }
}
</script>
