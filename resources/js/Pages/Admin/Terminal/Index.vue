<script setup>
import Terminal from '@/Components/Terminal.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router, useForm} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Terminal Prompt"/>
    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <h1 class="text-xl text-white uppercase mb-5 font-bold">Web Terminal</h1>
                <Terminal/>
            </div>
        </div>
    </AdminLayout>
</template>

