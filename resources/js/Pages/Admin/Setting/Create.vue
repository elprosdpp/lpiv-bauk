<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router, useForm, usePage} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from "@/Components/Pagination.vue";
import {ref, watch} from "vue";

//Get User After Login
const user = usePage().props.auth.user;

const props = defineProps({
    // users: {
    //     type: Object,
    //     default: () => ({}),
    // },
});


const form = useForm({
    user_id: user.id,
    ip_address_router: '',
    username_router: '',
    password_router: '',
});


function settingStore() {
    router.post(route('setting.store'), {
        _method: 'post',
        user_id: form.user_id,
        ip_address_router: form.ip_address_router,
        username_router: form.username_router,
        password_router: form.password_router,
    })
}

</script>

<template>
    <Head title="Setting"/>

    <AdminLayout>
        <div class="py-12 flex items-center justify-center">
            <div class="w-full">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <p class="text-2xl font-bold text-gray-700 inline-flex items-center dark:text-white">
                        <svg class="w-6 h-6 mr-2 animate-spin" fill="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                                  fill-rule="evenodd"/>
                        </svg>
                        Setting
                    </p>
                    <hr class="w-1/2 my-5 border-gray-500">
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <form class="flex flex-col gap-2 mt-10" @submit.prevent="settingStore">
                            <div class="w-1/2">
                                <input v-model="form.user_id" hidden type="text">
                                <div class="mb-5">
                                    <InputLabel for="title" value="IP Address"/>
                                    <TextInput
                                        v-model="form.ip_address_router"
                                        autocomplete="name"
                                        autofocus
                                        class="mt-1 block w-full"
                                        placeholder="IP Address"
                                        type="text"
                                    />
                                </div>
                            </div>
                            <div class="w-1/2">
                                <div class="mb-5 ">
                                    <InputLabel for="title" value="Username/Login"/>
                                    <TextInput
                                        v-model="form.username_router"
                                        autocomplete="name"
                                        class="mt-1 block w-full"
                                        placeholder="Username/Login"
                                        type="text"
                                    />
                                </div>
                            </div>
                            <div class="w-1/2">
                                <div class="mb-5 ">
                                    <InputLabel for="title" value="Password"/>
                                    <TextInput
                                        v-model="form.password_router"
                                        autocomplete="name"
                                        class="mt-1 block w-full"
                                        placeholder="********"
                                        type="password"
                                    />
                                </div>
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
            </div>

        </div>
    </AdminLayout>
</template>
