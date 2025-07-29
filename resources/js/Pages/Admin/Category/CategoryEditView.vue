<script setup>
import PageHeader from '@components/PageHeader.vue'
import BreadCrumbs from '@components/BreadCrumbs.vue'
import { useForm } from '@inertiajs/vue3'
import FormInput from '../../../Components/User/FormInput.vue';
import SubmitButton from '../../../Components/User/SubmitButton.vue';
import FormSelect from '../../../Components/User/FormSelect.vue';
import { computed, ref } from 'vue';
import CancelButton from '../../../Components/User/CancelButton.vue';
import { route } from 'ziggy-js';
import Filepond from '../../../Components/UI/Filepond.vue';

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
    image: props.category.image || null,
});

const initialFiles = ref([])
if (form.image) {
    initialFiles.value = [
        {
            source: form.image,
            options: {
                type: 'local',
                file: {
                    name: form.image,
                    size: null,
                    type: 'image/*',
                },
                metadata: {
                    poster: `/storage/category/image/${form.image}`,
                },
            },
        },
    ]
    console.log('Initial file for preview:', initialFiles.value)
}

const isParentCategory = computed(() => props.category.parent_id === null);
const parentCategories = computed(() =>
    props.categories
        .filter(c => c.parent_id === null && c.id !== props.category.id)
        .map(c => ({
            label: c.name,
            value: c.id,
        }))
)

const isUploading = ref(false)
const setUploading = (status) => {
    isUploading.value = status
}
const handleFileUpload = (fileId) => {
    form.image = fileId;

}

const handleFileRemove = () => {
    form.image = null;
}

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
                    <FormSelect v-model="form.parent_id" :options="parentCategories" name="Parent Category (optional)"
                        :disabled="isParentCategory" :message="form.errors.parent_id" />
                    <p v-if="isParentCategory" class="text-sm text-gray-500 mt-1">
                        Parent categories cannot be nested under other categories.
                    </p>
                </div>
                <div class="mt-2" v-if="initialFiles !== null">
                    <Filepond :multiple="false" :max-files="1" :files="initialFiles" @uploaded="handleFileUpload"
                        @uploading="setUploading" @removed="handleFileRemove" />
                    <p class="text-sm text-gray-500">One image allowed</p>
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
