<template>
    <div>

        <Head :title="` | ${page.component}`"></Head>
        hellow
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
const page = usePage();
</script>
