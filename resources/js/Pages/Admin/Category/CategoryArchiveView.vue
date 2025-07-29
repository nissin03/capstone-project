<script setup>
import { Package, ArchiveRestore, ChevronLeft } from 'lucide-vue-next'
import { computed, ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

import BreadCrumbs from '@components/BreadCrumbs.vue'
import SearchInput from '@components/SearchInput.vue'
import EmptyState from '@components/EmptyState.vue'
import PageHeader from '@components/PageHeader.vue'
import Modal from '../../../Components/UI/Modal.vue'
import ActionIcon from '../../../Components/UI/ActionIcon.vue'
import PaginationLinks from '../../../Components/UI/PaginationLinks.vue'
import { debounce } from 'lodash'

const props = defineProps({
    categories: Object,
})

const restoreModal = ref(false)
const expandedRows = ref(new Set())
const selectedRestoreId = ref(null)

const search = ref("")


watch(search,
    debounce((q) => router.get(route('admin.categories.archive'), { search: q }, { preserveState: true }), 500))

const subtitle = computed(() => {
    return search.value
        ? `No categories match '${search.value}'`
        : 'Get started by adding your first Category.'
});
function toggleRow(id) {
    if (expandedRows.value.has(id)) {
        expandedRows.value.delete(id)
    } else {
        expandedRows.value.add(id)
    }
}

function confirmRestore(id) {
    selectedRestoreId.value = id
    restoreModal.value = true
}

function restoreCategory() {
    router.put(route('admin.categories.restore', selectedRestoreId.value), {}, {
        preserveScroll: true,
        onSuccess: () => {
            restoreModal.value = false
        }
    })
}

</script>

<template>
    <div class="w-full space-y-6">

        <Head title="| Categories" />
        <PageHeader title="All Archived Categories">
            <template #breadcrumbs>
                <BreadCrumbs :items="[
                    { label: 'Dashboard', href: route('admin.dashboard') },
                    { label: 'Category', href: route('admin.categories.index') },
                    { label: 'All Archived Categories' }
                ]" />
            </template>
        </PageHeader>

        <div class="bg-white shadow-sm rounded-lg px-4 py-4 space-y-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="w-full md:max-w-sm">
                    <SearchInput placeholder="Filter Categories" v-model="search" />
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
                                            <img :src="category.image ? `/storage/category/image/${category.image}` : '/storage/category/image/default.png'"
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
                                            <ActionIcon :icon="ArchiveRestore"
                                                class="text-green-600 hover:text-green-800"
                                                @click="confirmRestore(category.id)" />
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="child in category.children" v-show="expandedRows.has(category.id)"
                                    :key="child.id" class="hover:bg-stone-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700">
                                        <div class="flex items-center gap-4 pl-8">
                                            <div class="space-y-1 flex-center space-x-5">
                                                <h2 class="font-medium text-sm text-stone-700">{{ child.name }}</h2>
                                                <p class="text-xs text-yellow-700 bg-yellow-100 px-1 py-0.5 rounded">
                                                    Subcategory</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <ActionIcon :icon="Archive"
                                                :class="{ 'text-gray-400 cursor-not-allowed': child.parent_id && !child.parent_trashed }"
                                                @click="child.parent_id && !child.parent_trashed ? null : confirmDelete(child.id)"
                                                :disabled="child.parent_id && !child.parent_trashed" />


                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                </div>
                <!-- Empty State -->
                <EmptyState :href="route('admin.categories.create')" v-else :icon="Package" title="No Category found" />
            </div>
        </div>
        <PaginationLinks :paginator="categories" />
    </div>
    <Modal :show="restoreModal">
        <div class="space-y-4">
            <h2 class="text-lg font-semibold">Do you want to restore this category?</h2>
            <div class="flex justify-end gap-2">
                <button @click="restoreModal = false" class="base-button-clr btn-secondary">Cancel</button>
                <button @click="restoreCategory" class="base-button-clr  btn-success ">Restore</button>
            </div>
        </div>
    </Modal>


</template>
