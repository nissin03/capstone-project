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
    categories: {
        type: Array,
        default: () => [],
    },
})
const form = useForm({
    name: '',
    slug: '',
    parent_id: null,
});


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
        onError: () => form.reset()
    });
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

                <div class="flex justify-end gap-2 mt-5 items-center">
                    <CancelButton :href="route('admin.categories.index')" />
                    <SubmitButton type="submit" :processing="form.processing">Create Category
                    </SubmitButton>
                </div>
            </form>
        </div>
    </div>
</template>
