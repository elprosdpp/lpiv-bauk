<script setup>
import {ref} from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditProfile from '@/Components/EditProfile.vue';
import {Head, router, useForm} from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const form = useForm({
    avatar: '',
});


// const preview = ref();
// const image = ref();
//
// const previewImage = (event) => {
//     const input = event.target;
//     if (input.files) {
//         const reader = new FileReader();
//         reader.onload = (e) => {
//             preview.value = e.target.result;
//         }
//         image.value = input.files[0];
//         reader.readAsDataURL(input.files[0]);
//     }
// };
</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <EditProfile class="max-w-xl"/>
                    <!--                    <UpdateProfileInformationForm-->
                    <!--                        :must-verify-email="mustVerifyEmail"-->
                    <!--                        :status="status"-->
                    <!--                        class="max-w-xl"-->
                    <!--                    />-->
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl"/>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
