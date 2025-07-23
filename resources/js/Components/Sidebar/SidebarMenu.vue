<script setup>
import { ref, computed, watch } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { ChevronDown } from "lucide-vue-next";

const page = usePage();
const props = defineProps({
    menuItems: Array,
    sidebarOpen: Boolean,
});

watch(() => props.sidebarOpen, (isOpen) => {
    if (!isOpen) {
        expandedItems.value = [];
    }
})
const normalizePath = (url) => {
    return new URL(url, window.location.origin).pathname || null;
};

const getActiveItemName = (items, currentPath) => {
    for (const item of items) {
        if (normalizePath(item.href) === currentPath) return item.name;
        if (item.children) {
            const child = item.children.find(child => normalizePath(child.href) === currentPath);
            if (child) return item.name;
        }
    }
    return null;
};

const expandedItems = ref([]);
const currentUrl = computed(() => page.url);
const activeItem = ref(getActiveItemName(props.menuItems, currentUrl.value));

router.on('finish', () => {
    const newUrl = page.url;
    const normalizedUrl = normalizePath(newUrl);

    let activeName = null;
    let expandedName = null;

    for (const item of props.menuItems) {
        if (normalizePath(item.href) === normalizedUrl) {
            activeName = item.name;
            break;
        }
        if (item.children) {
            const child = item.children.find(child => normalizePath(child.href) === normalizedUrl);
            if (child) {
                activeName = child.name;
                expandedName = item.name;
                break;
            }
        }
    }
    activeItem.value = activeName;
    if (expandedName) {
        expandedItems.value = [expandedName];
    } else {
        expandedItems.value = [];
    }
});

const menuItemsWithState = computed(() => {
    return props.menuItems.map((item) => {
        const isActive = activeItem.value === item.name ||
            (item.children && item.children.some(child => child.name === activeItem.value));
        const isExpanded = expandedItems.value.includes(item.name);
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
    const isAlreadyExpanded = expandedItems.value.includes(itemName);

    const isActiveOrChildActive =
        activeItem.value === itemName ||
        props.menuItems.find(item =>
            item.name === itemName &&
            item.children?.some(child => child.name === activeItem.value)
        );

    if (isAlreadyExpanded && isActiveOrChildActive) {
        expandedItems.value = [];
        activeItem.value = null;
    } else {
        expandedItems.value = [itemName];
        activeItem.value = itemName;
    }
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
                            class="block px-2 py-1.5 text-sm rounded cursor-pointer" :class="child.active
                                ? 'bg-stone-100 font-semibold text-stone-700'
                                : 'text-stone-600 hover:bg-stone-100'">
                        {{ child.name }}
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else>
                <Link :href="item.href"
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
