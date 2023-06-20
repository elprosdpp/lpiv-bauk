<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ArrayPagination from "@/Components/ArrayPagination.vue";
import {computed, onMounted, ref, watchEffect} from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue';

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
const data = props.detailHotspot;
const totalPage = Math.ceil(data.length / pageSize.value);
const searchQuery = ref('');

//Store User Hotspot
const name = ref('');
const password = ref('');
const profile = ref('');
const server = ref('');
//End Store User Hotspot

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

const isOpen = ref(false);

function closeModal() {
    isOpen.value = false;
}

function openModal() {
    isOpen.value = true;
}

const form = useForm({
    name: '',
    password: '',
    profile: '',
    server: ''
});

const storeUserHotspot = () => {
    form.post('/admin/hotspot/user/store/' + form.name + '/' + form.password + '/' + form.profile + '/' + form.server, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
        },
        onFinish: visit => {
            router.visit(window.location.pathname)
        },
    });
};


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

});
</script>

<template>

    <Head title="Hotspot List"/>


    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-3 gap-4 flex items-center">
                        <div class="col-span-2 flex">
                            <div v-if="can.create" class="flex space-x-2 items-center">
                                <!--                                <Link :href="route('hotspot.add')"-->
                                <!--                                      class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"-->
                                <!--                                >-->
                                <!--                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"-->
                                <!--                                         stroke-width="1.5"-->
                                <!--                                         stroke="currentColor" class="w-5 h-5 mr-2">-->
                                <!--                                        <path stroke-linecap="round" stroke-linejoin="round"-->
                                <!--                                              d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>-->
                                <!--                                    </svg>-->
                                <!--                                    Add User-->
                                <!--                                </Link>-->
                                <PrimaryButton
                                    class="inline-flex items-center rounded-md bg-black px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                    @click="openModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                                    </svg>
                                    Add User
                                </PrimaryButton>
                            </div>
                            <!--                            <Link :href="route('hotspot.active')"-->
                            <!--                                  class="inline-flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"-->
                            <!--                            >-->
                            <!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"-->
                            <!--                                     stroke-width="1.5"-->
                            <!--                                     stroke="currentColor" class="w-5 h-5 mr-2">-->
                            <!--                                    <path stroke-linecap="round" stroke-linejoin="round"-->
                            <!--                                          d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>-->
                            <!--                                </svg>-->
                            <!--                                User Active-->
                            <!--                            </Link>-->
                        </div>
                        <div class="relative col-end-7 col-span-2">
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
                                   placeholder="Search Users..."
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

        <!--Modal Create-->
        <TransitionRoot :show="isOpen" appear as="div">
            <Dialog as="div" class="relative z-50" @close="closeModal">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black bg-opacity-50"/>
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all dark:bg-gray-700"
                            >
                                <div class="relative w-full h-full max-w-md md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg dark:bg-gray-700">
                                        <button
                                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                            data-modal-hide="authentication-modal"
                                            type="button"
                                            @click="closeModal">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path clip-rule="evenodd"
                                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                      fill-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="px-6 py-6 lg:px-10 lg:pb-20">
                                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                Create User Hotspot</h3>
                                            <form class="space-y-6"
                                                  @submit.prevent="storeUserHotspot">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                        for="name">Name</label>
                                                    <input id="name" v-model="form.name"
                                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                           name="name"
                                                           placeholder="User"
                                                           required type="text">
                                                </div>

                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                        for="password">Password</label>
                                                    <input id="password" v-model="form.password"
                                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                           name="name"
                                                           placeholder="Password"
                                                           required type="text">
                                                </div>

                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                        for="profile">Profile</label>
                                                    <input id="profile" v-model="form.profile"
                                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                           name="name"
                                                           placeholder="TOP | USER"
                                                           required type="text">
                                                </div>

                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                        for="server">Server</label>
                                                    <input id="server" v-model="form.server"
                                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                           name="name"
                                                           placeholder="Server"
                                                           required type="text">
                                                </div>

                                                <button
                                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="submit"
                                                >
                                                    Save
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

    </AdminLayout>
</template>


