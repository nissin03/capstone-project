<script setup>
import { Edit, Trash2, Plus, Package, ArrowDownUp, ChevronDown } from 'lucide-vue-next'
import SearchInput from '@components/SearchInput.vue'
import BaseButton from '@components/BaseButton.vue'
import EmptyState from '@components/EmptyState.vue'
import PageHeader from '@components/PageHeader.vue'
import BreadCrumbs from '@components/BreadCrumbs.vue'
import Tooltip from '@components/Tooltip.vue'
import Table from '@components/Table.vue'

const columns = [
    { key: 'product', label: 'Product Name', sortable: true },
    { key: 'quantity', label: 'Quantity', sortable: true },
    { key: 'price', label: 'Price', sortable: true },
    { key: 'category', label: 'Category', sortable: true },
    { key: 'actions', label: 'Actions', align: 'right' }
]

const products = [
    {
        id: 1,
        name: 'Product Sample',
        image: 'https://placehold.co/200x200',
        category: 'Parent Category > Child Category',
        attributes: [
            { variant: 'Small / Red', quantity: 10, price: 1000 },
            { variant: 'Medium / Red', quantity: 20, price: 1100 },
            { variant: 'Large / greem', quantity: 15, price: 1200 }
        ]
    }
]

</script>

<template>
    <div class="w-full space-y-6">

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
                    <BaseButton class="w-full md:w-auto" :icon="Plus">
                        Add Product
                    </BaseButton>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-hidden">
                <div class="relative overflow-x-auto w-full">
                    <table class="min-w-full table-auto">
                        <thead class="bg-stone-50 border-b border-stone-300 ">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">
                                    Product Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">
                                    Price
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">
                                    Category
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-stone-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-stone-200">
                            <tr class="hover:bg-stone-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700 relative">
                                    <div class="flex items-center gap-4">
                                        <img src="https://placehold.co/200x200" alt="Product Image"
                                            class="w-10 h-10 rounded object-cover" />
                                        <div class="space-y-1">
                                            <div class="flex-center space-x-2">
                                                <h2 class="font-semibold text-xs">Product Sample</h2>
                                                <span
                                                    class="text-[10px] px-1 py-0.5 bg-green-100 text-green-700 rounded-md">Instock</span>
                                            </div>
                                            <div class="space-y-0.5 mt-1">
                                                <div class="text-[10px] text-stone-500">
                                                    <span class="font-medium text-stone-600">Size:</span>
                                                    Small, Medium, Large
                                                </div>
                                                <div class="text-[10px] text-stone-500">
                                                    <span class="font-medium text-stone-600">Color:</span>
                                                    Red, greem
                                                </div>
                                            </div>
                                            <!-- if no attribute  -->
                                            <!-- <span class="text-xs text-stone-400 italic text-[10px]">No attributes</span> -->
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700 relative">
                                    <!-- If has attributes -->
                                    <div class="space-y-1 text-[10px] text-stone-700">
                                        <div class="flex justify-between w-full">
                                            <span>Small / Red</span><span> 10</span>
                                        </div>
                                        <div class="flex justify-between w-full">
                                            <span>Medium / Red</span><span> 20</span>
                                        </div>
                                        <div class="flex justify-between w-full">
                                            <span>Large / greem</span><span> 15</span>
                                        </div>
                                    </div>
                                    <!-- If no attributes -->
                                    <!-- <span class="text-xs">2000</span> -->
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 relative">
                                    <!-- If has attributes -->
                                    <div class="space-y-1 text-[10px] text-stone-700">
                                        <div class="flex justify-between w-full">
                                            <span>Small / Red</span><span>₱ 1000</span>
                                        </div>
                                        <div class="flex justify-between w-full">
                                            <span>Medium / Red</span><span>₱ 1100</span>
                                        </div>
                                        <div class="flex justify-between w-full">
                                            <span>Large / greem</span><span>₱ 1200</span>
                                        </div>
                                    </div>

                                    <!-- If no attributes -->
                                    <!-- <span class="font-semibold">&#8369; 1000</span> -->
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 relative">
                                    <span class="text-[10px]">Parent Category > Child Category</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link href="#"
                                            class="p-2 text-stone-6 cursor-pointer00 hover:text-greem-600 hover:bg-greem-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-greem-500 focus:ring-offset-1">
                                        <Edit class="size-4" />
                                        </Link>
                                        <Link href="#"
                                            class="p-2 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                        <Trash2 class="size-4" />
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <EmptyState :icon="Package" title="No products found"
                    subtitle="Get started by adding your first product.">
                    Add Product
                </EmptyState>
            </div>
        </div>
    </div>
</template>
