<script setup>
import PageHeader from '@components/PageHeader.vue'
import BreadCrumbs from '@components/BreadCrumbs.vue'
import { useForm } from '@inertiajs/vue3'
import FormInput from '../../../Components/User/FormInput.vue';
import SubmitButton from '../../../Components/User/SubmitButton.vue';
import FormSelect from '../../../Components/User/FormSelect.vue';
import { computed, ref } from 'vue';
import CancelButton from '../../../Components/User/CancelButton.vue';
import Filepond from '../../../Components/UI/Filepond.vue'
import { route } from 'ziggy-js';

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    name: '',
    slug: '',
    parent_id: null,
    image: null,
});

const isUploading = ref(false)
const setUploading = (status) => {
    isUploading.value = status
}
const isParentCategory = computed(() => form.parent_id === null);
const parentCategories = computed(() =>
    props.categories
        .filter(category => category.parent_id === null)
        .map(category => ({
            label: category.name,
            value: category.id,
        }))
)

const submit = () => {

    form.post(route('admin.categories.store'), {
        preserveScroll: true,
        onError: () => {
            form.reset('image');
        },
    });
}


const handleFileUpload = (fileId) => {
    form.image = fileId;
}

const handleFileRemove = () => {
    form.image = null;
}
</script>

<template>
    <div class="w-full space-y-6">

        <Head title="| Create Category" />
        <PageHeader title="Create Category">
            <template #breadcrumbs>
                <BreadCrumbs :items="[
                    { label: 'Dashboard', href: route('admin.dashboard') },
                    { label: 'Category', href: route('admin.categories.index') },
                    { label: 'Create Category' }
                ]" />
            </template>
        </PageHeader>

        <div class="bg-white shadow-sm rounded-lg px-4 py-6 w-full space-y-6">
            <form @submit.prevent="submit">
                <FormInput v-model="form.name" type="text" name="Category" :message="form.errors.name" class="mb-5" />
                <div class="relative w-full">
                    <FormSelect v-model="form.parent_id" :options="parentCategories" name="Parent Category (optional)"
                        :message="form.errors.parent_id" />
                </div>
                <div class="mt-2" v-if="isParentCategory">
                    <Filepond :multiple="false" :max-files="1" @uploaded="handleFileUpload" @uploading="setUploading"
                        @removed="handleFileRemove" />
                    <p class="text-sm text-gray-500">One image allowed</p>
                </div>
                <div class="flex justify-end gap-2 mt-5 items-center">
                    <CancelButton :href="route('admin.categories.index')" />
                    <SubmitButton type="submit" :processing="form.processing || isUploading">Create Category
                    </SubmitButton>

                </div>
            </form>
        </div>
    </div>
</template>
