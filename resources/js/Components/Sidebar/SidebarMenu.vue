<script setup>
import { ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { ChevronDown } from "lucide-vue-next";

const page = usePage();
const props = defineProps({
    menuItems: Array,
});

const normalizePath = (url) => {
    return new URL(url, window.location.origin).pathname || null;
};

const getActiveItemName = (items, currentPath) => {
    for (const item of items) {
        if (normalizePath(item.href) === currentPath) return item.name;
        if (item.children) {
            const child = item.children.find(child => normalizePath(child.href) === currentPath);
            if (child) return child.name;
        }
    }
    return null;
};

const currentUrl = computed(() => page.url);
const activeItem = ref(getActiveItemName(props.menuItems, currentUrl.value));

watch(currentUrl, (newUrl) => {
    const newActive = getActiveItemName(props.menuItems, newUrl);
    activeItem.value = newActive;
});

const expandedItems = ref([]);

const menuItemsWithState = computed(() => {
    return props.menuItems.map((item) => {
        const isActive = activeItem.value === item.name ||
            (item.children && item.children.some(child => child.name === activeItem.value));
        const isExpanded = expandedItems.value.includes(item.name) || isActive;
        return {
            ...item,
            active: isActive,
            expanded: isExpanded,
            children: item.children?.map((child) => ({
                ...child,
                active: activeItem.value === child.name,
            })),
        };
    });
});

const toggleExpand = (itemName) => {
    if (expandedItems.value.includes(itemName)) {
        expandedItems.value = [];
    } else {
        expandedItems.value = [itemName];
    }
};

const setActive = (itemName) => {
    activeItem.value = itemName;
    expandedItems.value = [];
};
</script>
<template>
    <div class="space-y-1">
        <template v-for="item in menuItemsWithState" :key="item.name">

            <div v-if="item.children" class="space-y-1">
                <div @click="toggleExpand(item.name)"
                    class="flex items-center justify-start gap-2 w-full rounded px-2 py-1.5 text-sm transition-all cursor-pointer"
                    :class="item.active ? 'bg-white shadow text-stone-700' : 'text-stone-500 hover:bg-stone-200'">
                    <component :is="item.icon" class="size-4 shrink-0"
                        :class="item.expanded || item.active ? 'text-green-600' : 'text-stone-600'" />
                    <p class="truncate">{{ item.name }}</p>
                    <component :is="ChevronDown" :class="[
                        'ml-auto size-4 transition-transform duration-200',
                        item.expanded ? 'rotate-180 text-stone-700' : 'text-stone-600'
                    ]" />
                </div>
                <div class="grid transition-[grid-template-rows] duration-300 ease-in-out"
                    :class="item.expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                    <div class="overflow-hidden ml-6 mt-1 space-y-1">
                        <Link v-for="child in item.children" :key="child.name" :href="child.href"
                            @click="setActive(child.name)" class="block px-2 py-1.5 text-sm rounded cursor-pointer"
                            :class="child.active
                                ? 'bg-stone-100 font-semibold text-stone-700'
                                : 'text-stone-600 hover:bg-stone-100'">
                        {{ child.name }}
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else>
                <Link :href="item.href" @click="setActive(item.name)"
                    class="flex items-center justify-start gap-2 w-full rounded px-2 py-1.5 text-sm transition-all cursor-pointer"
                    :class="item.active ? 'bg-white shadow text-stone-700' : 'text-stone-500 hover:bg-stone-200'">
                <component :is="item.icon" class="size-4 shrink-0"
                    :class="item.expanded || item.active ? 'text-green-600' : 'text-stone-600'" />
                <p class="truncate">{{ item.name }}</p>
                </Link>
            </div>
        </template>
    </div>
</template>
