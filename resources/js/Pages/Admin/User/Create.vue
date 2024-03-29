<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect'

const users = usePage().props.auth.user;

const props = defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
});
</script>

<template>

    <Head title="Add User"/>

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <!--Form Role Edit-->
                <Link :href="route('users.index')"
                      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    <svg aria-hidden="true" class="w-4 h-4 inline-flex" fill="none" stroke="currentColor"
                         stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" stroke-linecap="round"
                              stroke-linejoin="round"></path>
                    </svg>
                    Back
                </Link>


                <form class="flex flex-col mt-10" @submit.prevent="form.post(route('users.store'))">
                    <div class="mb-5">
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

                    <div class="mb-5">
                        <InputLabel for="email" value="Email"/>
                        <TextInput
                            id="name"
                            v-model="form.email"
                            autocomplete="email"
                            autofocus
                            class="mt-1 block w-full"
                            type="email"
                        />
                        <InputError :message="form.errors.email" class="mt-2"/>
                    </div>

                    <div class="mb-5">
                        <InputLabel for="password" value="Password"/>
                        <TextInput
                            id="name"
                            v-model="form.password"
                            autocomplete="password"
                            autofocus
                            class="mt-1 block w-full"
                            type="password"
                        />
                        <InputError :message="form.errors.password" class="mt-2"/>
                    </div>

                    <div class="mb-5">
                        <InputLabel for="password_confirmation" value="Confirm Password"/>

                        <TextInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            autocomplete="new-password"
                            class="mt-1 block w-full"
                            required
                            type="password"
                        />

                        <InputError :message="form.errors.password_confirmation" class="mt-2"/>
                    </div>

                    <div>
                        <InputLabel for="role" value="Role" class="mb-2"/>
                        <multiselect
                            v-model="form.role"
                            :options="props.roles"
                            placeholder="Select Role">
                        </multiselect>
                        <InputError :message="form.errors.role" class="mt-2"/>
                    </div>

                    <div class="flex items-center gap-4 mt-4">
                        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                        <Transition class="transition ease-in-out" enter-from-class="opacity-0"
                                    leave-to-class="opacity-0">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>

</template>

<style src="@vueform/multiselect/themes/default.css"></style>
