<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Multiselect from '@vueform/multiselect'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue';
import {ref} from "vue";

const page = usePage();

const isOpen = ref(false);

const form = useForm({
    name: '',
    permission: []
});

const storeRole = () => {
    form.post(route('role.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
        },
    });
};

const props = defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
    permission: {
        type: Object,
        default: () => ({}),
    }
});

function closeModal() {
    isOpen.value = false;
}

function openModal() {
    isOpen.value = true;
}
</script>

<template>
    <Head title="Role"/>

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="overflow-hidden sm:rounded-lg">
                    <div class="flex justify-between items-center">
                        <div v-if="can.create" class="flex space-x-2 items-center">
                            <PrimaryButton
                                class="rounded-md bg-black px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                @click="openModal">
                                Tambah Role
                            </PrimaryButton>
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
                            <th class="py-3 px-6" scope="col">Permissions</th>
                            <th v-if="can.edit || can.delete" class="py-3 px-6" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="role in props.roles" :key="role.role_id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6" data-label="Name">
                                {{ role.name }}
                            </td>
                            <td v-if="role.permission_name" class="flex flex-wrap py-4 px-6 max-w-2xl">
                                <div v-for="(r, index) in role.permission_name.split(',')" :key="index"
                                     class="flex flex-wrap">
                                    <span
                                        class="bg-blue-100 mb-2 text-blue-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">{{ r }}</span>
                                </div>
                            </td>
                            <td v-else>No Permission</td>
                            <td
                                v-if="can.edit || can.delete"
                                class="py-4 px-6"
                            >
                                <div class="flex space-x-2">
                                    <Link v-if="can.edit"
                                          :href="route('role.edit', role.role_id)"
                                          class="ml-4 bg-blue-500 px-2 py-1 rounded text-white cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                        </svg>
                                    </Link>
                                    <Link v-if="can.edit"
                                          :href="route('role.destroy', role.role_id)"
                                          as="button"
                                          class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer"
                                          method="DELETE"
                                          onclick="return confirm('Yakin Akan Menghapus Data Ini?')">
                                        <svg class="w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5"
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
                                                    Create Role</h3>
                                                <form class="space-y-6"
                                                      @submit.prevent="storeRole">
                                                    <div>
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                            for="name">Role
                                                            Name</label>
                                                        <input id="name" v-model="form.name"
                                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                               name="name"
                                                               placeholder="Admin | Writter | User"
                                                               required type="text">
                                                    </div>

                                                    <InputLabel for="permission" value="Permission Add" class="-mb-6"/>
                                                    <multiselect
                                                        v-model="form.permission"
                                                        :allow-absent="true"
                                                        :close-on-select="false"
                                                        :hideSelected="true"
                                                        :options="props.permission"
                                                        :searchable="true"
                                                        class="mt-3"
                                                        label="name"
                                                        mode="tags"
                                                        placeholder="Select Permission"
                                                        track-by="name">
                                                    </multiselect>

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

<style src="@vueform/multiselect/themes/default.css"></style>
