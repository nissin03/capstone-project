<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import CustomCheckbox from '../../Components/User/CustomCheckbox.vue';
import GoogleLoginBtn from '../../Components/User/GoogleLoginBtn.vue';
import FormInput from '../../Components/User/FormInput.vue';
import SubmitButton from '../../Components/User/SubmitButton.vue';
import AuthLayout from '../../Components/User/AuthLayout.vue';
const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const submit = () => {
    form.post(route('login'), {
        preserveScroll: true,
        onError: () => form.reset('password', 'remember')
    });
}
const redirectToGoogle = () => {
    window.location.href = '/auth/google'
}
</script>
<template>
    <AuthLayout title="| Login">
        <template #heading>
            Sign in to your account
        </template>
        <form @submit.prevent="submit">
            <div class="mx-auto max-w-md space-y-3">
                <FormInput v-model="form.email" type="email" name="Email" :message="form.errors.email" />
                <FormInput v-model="form.password" type="password" name="Password" :message="form.errors.password" />
                <div class="flex-items justify-between mb-3">
                    <CustomCheckbox v-model="form.remember" label="Remember me" />
                    <Link href="#" as="button" type="button"
                        class="underline text-sm font-semibold text-green-500 hover:text-green-600">
                    Forgot Password?
                    </Link>
                </div>

                <SubmitButton type="submit" :processing="form.processing">Login</SubmitButton>
            </div>
        </form>
        <div class="mt-8 text-center text-sm">
            <div class="flex justify-center border-t dark:border-stone-600">
                <div class="-mt-5 bg-white p-2 text-stone-600">
                    Or continue with
                </div>
            </div>
        </div>
        <div class="mt-4">
            <GoogleLoginBtn @google-login="redirectToGoogle" />
        </div>
    </AuthLayout>
</template>
