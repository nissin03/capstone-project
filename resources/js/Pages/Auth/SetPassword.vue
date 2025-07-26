<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import FormInput from '../../Components/User/FormInput.vue';
import SubmitButton from '../../Components/User/SubmitButton.vue';
import AuthLayout from '../../Components/User/AuthLayout.vue';
import { route } from 'ziggy-js';

const form = useForm({
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        preserveScroll: true,
        onError: () => form.reset('password', 'password_confirmation')
    });
}

</script>
<template>
    <AuthLayout title="| Login">
        <template #heading>
            Reset your password
        </template>
        <form @submit.prevent="submit">
            <div class="mx-auto max-w-md space-y-3">
                <FormInput v-model="form.password" type="password" name="password" :message="form.errors.password" />
                <FormInput v-model="form.password_confirmation" type="password" name="password_confirmation"
                    :message="form.errors.password_confirmation" />
                <SubmitButton type="submit" :processing="form.processing">Set Password</SubmitButton>
            </div>
        </form>
    </AuthLayout>
</template>
