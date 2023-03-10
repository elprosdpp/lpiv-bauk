<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    users: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})
</script>

<template>
    <Head title="Users"/>

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex bg-gray-800 justify-between items=center p-5">
                        <div class="flex space-x-2 items-center text-white">
                            Users Settings Page! Here you can list, create, update or delete user!
                        </div>
                        <div v-if="can.create" class="flex space-x-2 items-center">
                            <a class="px-4 py-2 bg-green-500 uppercase text-white rounded focus:outline-none flex items-center"
                               href="#"><span
                                class="iconify mr-1" data-icon="gridicons:create" data-inline="false"></span> Create
                                User</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="py-3 px-6" scope="col">Name</th>
                            <th class="py-3 px-6" scope="col">Email</th>
                            <th v-if="can.edit || can.delete" class="py-3 px-6" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users.data" :key="user.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6" data-label="Name">
                                {{ user.name }}
                            </td>
                            <td class="py-4 px-6" data-label="Email">
                                {{ user.email }}
                            </td>
                            <td
                                v-if="can.edit || can.delete"
                                class="py-4 px-6"
                            >
                                <div type="justify-start lg:justify-end">
                                    <PrimaryButton v-if="can.edit"
                                                  class="ml-4 bg-green-500 px-2 py-1 rounded text-white cursor-pointer">
                                        Edit
                                    </PrimaryButton>
                                    <PrimaryButton v-if="can.delete"
                                                  class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer">
                                        Delete
                                    </PrimaryButton>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
