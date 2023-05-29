<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from "@/Components/Pagination.vue";
import {ref, watch} from "vue";


const props = defineProps({
    // users: {
    //     type: Object,
    //     default: () => ({}),
    // },
    can: {
        type: Object,
        default: () => ({}),
    },
    // filters: {
    //     type: Object,
    //     default: () => ({}),
    // },
});

// const search = ref(props.filters?.search);

// watch(search, (value) => {
//     router.get(
//         "/admin/users",
//         {search: value},
//         {
//             preserveState: true,
//             replace: true,
//         }
//     );
// });
</script>

<template>
    <Head title="Setting"/>

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center">
                        <div v-if="can.create" class="flex space-x-2 items-center">
                            <Link :href="route('setting.create')"
                                  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                            >
                                Edit Setting
                            </Link>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"></path>
                                </svg>
                            </div>
                            <!--                            <input v-model="search"-->
                            <!--                                   class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"-->
                            <!--                                   placeholder="Search Users..."-->
                            <!--                                   required type="search">-->
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
                        <!--                        <tr v-for="user in users.data" :key="user.id"-->
                        <!--                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">-->
                        <!--                            <td class="py-4 px-6" data-label="Name">-->
                        <!--                                {{ user.name }}-->
                        <!--                            </td>-->
                        <!--                            <td class="py-4 px-6" data-label="Email">-->
                        <!--                                {{ user.email }}-->
                        <!--                            </td>-->
                        <!--                            <td-->
                        <!--                                v-if="can.edit || can.delete"-->
                        <!--                                class="py-4 px-6"-->
                        <!--                            >-->
                        <!--                                <div class="flex space-x-2">-->
                        <!--                                    <Link v-if="can.edit"-->
                        <!--                                          :href="route('users.edit', user.id)"-->
                        <!--                                          class="ml-4 bg-blue-500 px-2 py-1 rounded text-white cursor-pointer">-->
                        <!--                                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor"-->
                        <!--                                             stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                        <!--                                            <path-->
                        <!--                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"-->
                        <!--                                                stroke-linecap="round"-->
                        <!--                                                stroke-linejoin="round"></path>-->
                        <!--                                        </svg>-->
                        <!--                                    </Link>-->
                        <!--                                    <Link v-if="can.edit"-->
                        <!--                                          :href="route('users.destroy', user.id)"-->
                        <!--                                          as="button"-->
                        <!--                                          class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer"-->
                        <!--                                          method="DELETE"-->
                        <!--                                          onclick="return confirm('Yakin Akan Menghapus Data Ini?')">-->
                        <!--                                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor"-->
                        <!--                                             stroke-width="1.5"-->
                        <!--                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                        <!--                                            <path-->
                        <!--                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"-->
                        <!--                                                stroke-linecap="round"-->
                        <!--                                                stroke-linejoin="round"></path>-->
                        <!--                                        </svg>-->
                        <!--                                    </Link>-->
                        <!--                                </div>-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
            <!--            <Pagination :data="props?.users"/>-->
        </div>
    </AdminLayout>
</template>
