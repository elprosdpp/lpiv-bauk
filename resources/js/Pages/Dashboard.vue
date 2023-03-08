<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import AdminLayout from "../Layouts/AdminLayout.vue";

import {ref} from 'vue'

</script>

<template>
    <Head title="Dashboard"/>

    <!--    <AuthenticatedLayout>-->
    <!--        <template #header>-->
    <!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>-->
    <!--        </template>-->

    <!--        <div class="py-12">-->

    <!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
    <!--                <div v-if="$page.props.flash.message" class="absolute right-10 bottom-10 z-10">-->
    <!--                    <Toast :message="$page.props.flash.message"/>-->
    <!--                </div>-->
    <!--                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">-->
    <!--                    <div class="p-6 text-gray-900">You're logged in!</div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </AuthenticatedLayout>-->

    <AdminLayout>
        <div class="grid grid-cols-3 gap-4 mb-4 ">
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>

        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
        </div>
    </AdminLayout>
</template>
