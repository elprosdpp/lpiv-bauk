<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ArrayPagination from "@/Components/ArrayPagination.vue";
import {computed, onMounted, ref, watchEffect} from "vue";

const props = defineProps({
    detailHotspot: {
        type: Array,
        default: () => ([]),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})

const currentPage = ref(1);
const pageSize = ref(10);
const number = ref(1);
const data = props.detailHotspot;
const totalPage = Math.ceil(data.length / pageSize.value);
const searchQuery = ref('');

// function Paginator(items, page, per_page) {
//
//     const currentPage = page || 1;
//     const perPage = per_page || 10;
//     const offset = (page - 1) * per_page;
//
//     const paginatedItems = props.detailHotspot.slice(offset).slice(0, perPage);
//     const total_pages = Math.ceil(props.detailHotspot.length / perPage);
//     return {
//         page: currentPage,
//         per_page: perPage,
//         pre_page: currentPage - 1 ? currentPage - 1 : null,
//         next_page: (total_pages > currentPage) ? currentPage + 1 : null,
//         total: props.detailHotspot.length,
//         total_pages: total_pages,
//         data: paginatedItems
//     };
// }


const filteredItems = computed(() => {
    const filtered = data.filter(item => {
        return item.name.toLowerCase().includes(searchQuery.value.toLowerCase());
    });

    const startIndex = (currentPage.value - 1) * pageSize.value;
    const endIndex = startIndex + pageSize.value;

    return filtered.slice(startIndex, endIndex);
});

const totalPages = computed(() => {
    return Math.ceil(filteredItems.value.length / pageSize.value);
});

const onPageChange = (page) => {
    currentPage.value = page;
}

// onMounted(() => {
//     // getMatchingResults()
// })

watchEffect(() => {
    console.log(currentPage.value)
});
</script>

<template>

    <Head title="Hotspot List"/>


    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-end items-center">
                        <!--                        <div v-if="can.create" class="flex space-x-2 items-center">-->
                        <!--                            <PrimaryButton-->
                        <!--                                class="rounded-md bg-black px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"-->
                        <!--                                @click="openModal">-->
                        <!--                                Tambah Permission-->
                        <!--                            </PrimaryButton>-->
                        <!--                        </div>-->

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"></path>
                                </svg>
                            </div>
                            <input v-model="searchQuery"
                                   class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Search User Hotspot"
                                   required type="search">
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="py-3 px-6" scope="col">Name</th>
                            <th class="py-3 px-6" scope="col">Profile</th>
                            <th class="py-3 px-6" scope="col">Uptime</th>
                            <th v-if="can.edit || can.delete" class="py-3 px-6" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="detail in filteredItems" :key="detail['.id']"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6" data-label="Title">
                                {{ detail['name'] }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ detail['profile'] }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ detail['uptime'] }}
                            </td>

                            <td
                                v-if="can.edit || can.delete"
                                class="py-4 px-6 w-48"
                            >
                                <div class="flex space-x-2">
                                    <Link v-if="can.edit"
                                          href="#"
                                          class="px-2 py-1 rounded text-white bg-blue-500 cursor-pointer flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Detail
                                    </Link>
                                    <!--                                    <Link v-if="can.delete"-->
                                    <!--                                          :href="route('post.destroy', post.id)"-->
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
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="my-10" v-if="totalPages">
                    <ArrayPagination
                        :totalPages="searchQuery === '' ? totalPage : totalPages"
                        :perPage="pageSize"
                        :currentPage="currentPage"
                        @pagechanged="onPageChange"/>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>


