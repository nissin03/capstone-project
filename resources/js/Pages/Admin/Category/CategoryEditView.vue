<script setup>
import PageHeader from '@components/PageHeader.vue'
import BreadCrumbs from '@components/BreadCrumbs.vue'
import { useForm } from '@inertiajs/vue3'
import FormInput from '../../../Components/User/FormInput.vue';
import SubmitButton from '../../../Components/User/SubmitButton.vue';
import FormSelect from '../../../Components/User/FormSelect.vue';
import { computed } from 'vue';
import CancelButton from '../../../Components/User/CancelButton.vue';
import { route } from 'ziggy-js';

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },

    categories: {
        type: Array,
        default: () => [],
    },
})
const form = useForm({
    name: props.category.name || '',
    slug: props.category.slug || '',
    parent_id: props.category.parent_id || null,
});

const isParentCategory = computed(() => props.category.parent_id === null);
const parentCategories = computed(() =>
    props.categories
        .filter(c => c.parent_id === null && c.id !== props.category.id)
        .map(c => ({
            label: c.name,
            value: c.id,
        }))
)

const submit = () => {
    form.put(route('admin.categories.update', props.category.id), {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="w-full space-y-6">

        <Head title="| Edit Category" />
        <PageHeader title="Edit Category">
            <template #breadcrumbs>
                <BreadCrumbs :items="[
                    { label: 'Dashboard', href: route('admin.dashboard') },
                    { label: 'Category', href: route('admin.categories.index') },
                    { label: 'Edit Category' }
                ]" />
            </template>
        </PageHeader>

        <div class="bg-white shadow-sm rounded-lg px-4 py-6 w-full space-y-6">
            <form @submit.prevent="submit">

                <FormInput v-model="form.name" type="text" name="Category" :message="form.errors.name" class="mb-5" />
                <div class="relative w-full">
                    <FormSelect v-model="form.parent_id" :options="parentCategories" name="Parent Categorye (optional)"
                        :disabled="isParentCategory" :message="form.errors.parent_id" />
                    <p v-if="isParentCategory" class="text-sm text-gray-500 mt-1">
                        Parent categories cannot be nested under other categories.
                    </p>

                </div>

                <div class="flex justify-end gap-2 mt-5 items-center">
                    <CancelButton :href="route('admin.categories.index')" />
                    <SubmitButton type="submit" :processing="form.processing">
                        Update Category
                    </SubmitButton>
                </div>
            </form>
        </div>
    </div>
</template>
