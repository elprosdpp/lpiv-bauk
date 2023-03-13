<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm, usePage, router} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect'
import {onMounted, ref} from "vue";

const user = usePage().props.auth.user;

const props = defineProps({
    role: {
        type: Object
    },
    permission: {
        type: Object
    },
    permissionId: {
        type: Object
    },
    permissionJSON: {
        type: Object
    }
});


const form = useForm({
    name: props.role.name,
    permission: props.permissionJSON,
});

</script>


<template>
    <Head title="Edit Role"/>
    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">

                <!--Form Role Edit-->
                <Link :href="route('role.index')"
                      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                      >
                    <svg class="w-4 h-4 inline-flex" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                    Back
                </Link>

                <form class="flex flex-col mt-10" @submit.prevent="$event=>form.put(route('role.update', role.id))">
                    <div>
                        <InputLabel for="name" value="Name"/>
                        <TextInput
                            id="name"
                            v-model="form.name"
                            autocomplete="name"
                            autofocus
                            class="mt-1 block w-full"
                            type="text"
                        />
                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>

                    <div class="flex items-center gap-4 mt-4">
                        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                        <Transition class="transition ease-in-out" enter-from-class="opacity-0"
                                    leave-to-class="opacity-0">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                        </Transition>
                    </div>
                </form>

                <hr class="my-10">

                <!--Form Add Permission-->
                <div class="container">
                    <form @submit.prevent="form.post(route('role.permissions', role.id))">
                        <InputLabel for="permission" value="Permission Add" class="mb-2"/>
                        <multiselect
                            v-model="form.permission"
                            :allow-absent="true"
                            :close-on-select="false"
                            :hideSelected="true"
                            :options="props.permission"
                            :searchable="true"
                            label="name"
                            mode="tags"
                            placeholder="Select Permission"
                            track-by="name">
                        </multiselect>

                        <!--                    <pre class="language-json text-white"><code>{{ props.permissionJSON }}</code></pre>-->
                        <InputError :message="form.errors.name" class="mt-2"/>

                        <div class="flex items-center gap-4 mt-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                            <Transition class="transition ease-in-out" enter-from-class="opacity-0"
                                        leave-to-class="opacity-0">
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </div>

                <hr class="my-10">

                <!--Permission -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="py-3 px-6" scope="col">Permission</th>
                            <th class="py-3 px-6" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="rolePermission in props.permissionId" :key="rolePermission.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6" data-label="Name">
                                {{ rolePermission.name }}
                            </td>
                            <td class="py-4 px-6">
                                <div type="justify-start lg:justify-end">
                                    <Link :href="route('roles.permissions.revoke', [role.id, rolePermission.id])"
                                          as="button"
                                          class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer  mb-2"
                                          method="DELETE"
                                          onclick="return confirm('Yakin Akan Menghapus Data Ini?')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5"
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
        </div>
    </AdminLayout>

</template>

<style src="@vueform/multiselect/themes/default.css"></style>
