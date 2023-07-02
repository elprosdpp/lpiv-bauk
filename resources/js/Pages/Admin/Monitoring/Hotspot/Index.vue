<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import ArrayPagination from "@/Components/ArrayPagination.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {useDebounce} from '@vueuse/core';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue';

//initialization props Data From Backend
const props = defineProps({
    items: {
        type: Object,
        default: () => ({}),
    },
    profile: {
        type: Object,
        default: () => ({}),
    },
    totalActive: {
        type: Number,
        default: 0
    },
    searchQuery: {
        type: String,
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})

//Modal Functions
const isOpen = ref(false);

function closeModal() {
    isOpen.value = false;
}

function openModal() {
    isOpen.value = true;
}

//Store User Hotspot
const form = useForm({
    name: '',
    password: '',
    profile: 'Select Profile',
    server: 'hotspot1'
});

const storeUserHotspot = () => {
    form.post(route('hotspot.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
        },
        // onFinish: visit => {
        //     router.visit(window.location.pathname)
        // },
    });
};

//Search deBounce VueUse
const searchQuery = ref(props?.searchQuery);
const search = useDebounce(searchQuery, 500);


// Metode untuk navigasi halaman
function goToPage(page) {
    router.visit(route('hotspot.index', {page, search: props.searchQuery}));
}

//Watch Search Input
watch(search, (search) => {
    router.visit(route('hotspot.index', {search}));
});

</script>

<template>

    <Head title="Hotspot List"/>


    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
                <!--                <p class="text-white"> {{ props.totalActive }}</p>-->
                <div
                    class="grid grid-cols-3 gap-4 mb-4 sm:rounded-lg border-2 p-2 border-gray-100 dark:border-gray-700">
                    <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="flex items-center mt-4">
                            <div class="mx-14">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-8 h-8 text-gray-500 dark:text-white">
                                    <path fill-rule="evenodd"
                                          d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.54 15h6.42l.5 1.5H8.29l.5-1.5zm8.085-8.995a.75.75 0 10-.75-1.299 12.81 12.81 0 00-3.558 3.05L11.03 8.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 001.146-.102 11.312 11.312 0 013.612-3.321z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="-ml-10">
                                <p class="text-gray-500 dark:text-white">Users Active</p>
                                <p class="text-lg text-gray-400 dark:text-gray-500">{{ props.totalActive }} User
                                    Online</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="flex items-center mt-4">
                            <div class="mx-14">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-8 h-8 text-gray-500 dark:text-white">
                                    <path fill-rule="evenodd"
                                          d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
                                          clip-rule="evenodd"/>
                                    <path
                                        d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z"/>
                                </svg>


                            </div>
                            <div class="-ml-10">
                                <p class="text-gray-500 dark:text-white">Profile</p>
                                <p class="text-lg text-gray-400 dark:text-gray-500">{{ props.profile.length }}
                                    Profile Hotspot</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="flex items-center mt-4">
                            <div class="mx-14">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-8 h-8 text-gray-500 dark:text-white">
                                    <path fill-rule="evenodd"
                                          d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                          clip-rule="evenodd"/>
                                </svg>

                            </div>
                            <div class="-ml-10">
                                <p class="text-gray-500 dark:text-white">Users</p>
                                <p class="text-lg text-gray-400 dark:text-gray-500">{{ props.items.total }} Users
                                    Hotspot</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="overflow-hidden sm:rounded-lg">
                    <div class="grid grid-cols-3 gap-4 flex items-center">
                        <div class="col-span-2 flex">
                            <div v-if="can.create" class="flex space-x-2 items-center">

                                <PrimaryButton
                                    class="inline-flex mr-3 items-center rounded-md bg-black px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                    @click="openModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                                    </svg>
                                    Add User
                                </PrimaryButton>

                            </div>
                            <Link :href="route('hotspot.active')"
                                  class="inline-flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                                </svg>
                                User Active
                            </Link>
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
                            <th class="py-3 px-6" scope="col">No</th>
                            <th class="py-3 px-6" scope="col">Name</th>
                            <th class="py-3 px-6" scope="col">Profile</th>
                            <th class="py-3 px-6" scope="col">Uptime</th>
                            <th v-if="can.edit || can.delete" class="py-3 px-6" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(phost, index) in props.items.data" :key="index"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6" data-label="Title">
                                {{ props.items.from + index }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ phost['name'] }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ phost['profile'] }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ phost['uptime'] }}
                            </td>

                            <td
                                v-if="can.edit || can.delete"
                                class="py-4 px-6 w-48"
                            >
                                <div class="flex space-x-2">
                                    <Link v-if="can.edit"
                                          :href="'/admin/hotspot/profile/'+ phost['name']"
                                          class="px-2 py-1 rounded text-white bg-blue-500 cursor-pointer flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <!--                                        Detail-->
                                    </Link>
                                    <Link v-if="can.delete"
                                          :href="route('hotspot.destroy', phost['.id'])"
                                          as="button"
                                          class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer"
                                          method="DELETE"
                                          onclick="return confirm('Yakin Akan Menghapus Data Ini?')">
                                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor"
                                             stroke-width="1.5"
                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="props.items.total > 3">
                    <ArrayPagination
                        :totalPages="props.items.last_page"
                        :perPage="props.items.per_page"
                        :currentPage="props.items.current_page"
                        @pagechanged="goToPage"/>
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
                                                        <select
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                            v-model="form.profile">
                                                            <option selected>Select Profile</option>
                                                            <option v-for="profile in props.profile" :key="['.id']"
                                                                    :value="profile['name']">{{ profile['name'] }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                            for="server">Server</label>
                                                        <input id="server" v-model="form.server"
                                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                               name="name"
                                                               placeholder="Server"
                                                               required type="text" disabled>
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
        </div>
    </AdminLayout>
</template>


