<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm, usePage, router} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {ref} from "vue";

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
    }
})

const form = useForm({
    name: props.role.name,
    permission: ''
});


</script>


<template>
    <Head title="Edit Role"/>
    <AdminLayout>
        <div class="py-12">
            <form class="flex flex-col" @submit.prevent="$event=>form.put(route('role.update', role.id))">
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

            <div class="container p-5 border-2 my-4 rounded-lg">
                <form @submit.prevent="form.post(route('role.permissions', role.id))">
                    <div v-for="permission in props.permission" :key="permission.id" class="flex items-center mb-4">
                        <input
                            :value="form.permission = permission.name"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            type="checkbox"
                            @input="form.permission = $event.target.value">
                        <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="default-checkbox">
                            {{ permission.name }}</label>

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
            </div>

            <div v-for="rolePermission in props.permissionId" :key="permission.id" class="">
                <div class="flex mx-auto">
<!--                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"-->
                    <!--                            type="button">-->
                    <!--                        {{ rolePermission.name }}-->
                    <!--                    </button>-->
                    <Link :href="route('roles.permissions.revoke', [role.id, rolePermission.id])"
                          method="DELETE" as="button"
                          onclick="return confirm('Yakin Akan Menghapus Data Ini?')"
                          class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer  mb-2">
                        {{ rolePermission.name }}
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>

</template>
