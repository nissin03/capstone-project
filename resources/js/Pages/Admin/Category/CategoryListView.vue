<script setup>
import { Edit, Plus, Package, Archive, ChevronLeft } from 'lucide-vue-next'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

import BreadCrumbs from '@components/BreadCrumbs.vue'
import SearchInput from '@components/SearchInput.vue'
import BaseButton from '@components/BaseButton.vue'
import EmptyState from '@components/EmptyState.vue'
import PageHeader from '@components/PageHeader.vue'
import Modal from '../../../Components/UI/Modal.vue'
import ActionIcon from '../../../Components/UI/ActionIcon.vue'
import PaginationLinks from '../../../Components/UI/PaginationLinks.vue'

const props = defineProps({
    categories: Object,
})

const showModal = ref(false)
const expandedRows = ref(new Set())
const selectedCategoryId = ref(null)

function toggleRow(id) {
    if (expandedRows.value.has(id)) {
        expandedRows.value.delete(id)
    } else {
        expandedRows.value.add(id)
    }
}

function confirmDelete(id) {
    selectedCategoryId.value = id
    showModal.value = true
}

function archiveCategory() {
    router.delete(route('admin.categories.destroy', selectedCategoryId.value), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false
        }
    })
}
</script>

<template>
    <div class="w-full space-y-6">

        <Head title="| Categories" />
        <PageHeader title="All Products">
            <template #breadcrumbs>
                <BreadCrumbs :items="[
                    { label: 'Dashboard', href: route('admin.dashboard') },
                    { label: 'All Products' }
                ]" />
            </template>
        </PageHeader>

        <div class="bg-white shadow-sm rounded-lg px-4 py-4 space-y-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="w-full md:max-w-sm">
                    <SearchInput placeholder="Filter Categories" />
                </div>

                <div class="w-full md:w-auto flex flex-wrap justify-end gap-2">
                    <BaseButton :href="route('admin.categories.create')" class="w-full md:w-auto" :icon="Plus">
                        Add Category
                    </BaseButton>
                </div>
            </div>

            <div class="overflow-hidden">
                <div v-if="$page.props.flash.message"
                    class="bg-green-100 text-green-700 mb-4 flex items-start px-3 py-2 rounded-md border border-green-300">
                    {{ $page.props.flash.message }}
                </div>
                <div v-if="categories?.data?.length > 0" class="relative overflow-x-auto w-full">
                    <table class="min-w-full table-auto">
                        <thead class="bg-stone-50 border-b border-stone-300 ">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">
                                    Category Name
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-stone-700 uppercase tracking-wider flex items-center justify-end gap-2">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-stone-200">
                            <template v-for="category in categories.data" :key="category.id">
                                <tr class="hover:bg-stone-50 transition-colors" @click="toggleRow(category.id)">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700">
                                        <div class="flex items-center gap-4">
                                            <div v-if="category.children.length"
                                                class="transition-transform duration-200" :class="{
                                                    'rotate-0': !expandedRows.has(category.id),
                                                    '-rotate-90': expandedRows.has(category.id)
                                                }">
                                                <ChevronLeft class="size-4 text-stone-500" />
                                            </div>
                                            <img :src="category.image ? `/storage/${category.image}` : 'https://placehold.co/200x200'"
                                                class="w-10 h-10 rounded object-cover" />
                                            <div class="space-y-1">
                                                <h2 class="font-semibold text-sm">{{ category.name }}</h2>
                                                <p class="text-xs text-green-700 bg-green-100 px-1 py-0.5 rounded">
                                                    Parent Category</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <ActionIcon :href="route('admin.categories.edit', category.id)"
                                                :icon="Edit" />

                                            <ActionIcon :icon="Archive" @click="confirmDelete(category.id)" />
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="child in category.children" v-show="expandedRows.has(category.id)"
                                    :key="child.id" class="hover:bg-stone-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700">
                                        <div class="flex items-center gap-4 pl-8">
                                            <img :src="child.image ? `/storage/${child.image}` : 'https://placehold.co/200x200'"
                                                class="w-8 h-8 rounded object-cover" />
                                            <div class="space-y-1 flex-center space-x-5">
                                                <h2 class="font-medium text-sm text-stone-700">{{ child.name }}</h2>
                                                <p class="text-xs text-yellow-700 bg-yellow-100 px-1 py-0.5 rounded">
                                                    Subcategory</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <ActionIcon :href="route('admin.categories.edit', child.id)" :icon="Edit" />
                                            <ActionIcon :icon="Archive" @click="confirmDelete(child.id)" />
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <!-- Pagination Links  -->
                    <PaginationLinks :paginator="categories" />
                </div>
                <!-- Empty State -->
                <EmptyState :href="route('admin.categories.create')" v-else :icon="Package" title="No Category found"
                    subtitle="Get started by adding your first Category.">
                    Add Category
                </EmptyState>
            </div>
        </div>
    </div>
    <Modal :show="showModal">
        <div class="space-y-4">
            <h2 class="text-lg font-semibold">Do you want to archive this category?</h2>
            <div class="flex justify-end gap-2">
                <button @click="showModal = false" class="base-button-clr btn-secondary">Cancel</button>
                <button @click="archiveCategory" class="base-button-clr btn-danger">Archive</button>
            </div>
        </div>
    </Modal>


</template>
