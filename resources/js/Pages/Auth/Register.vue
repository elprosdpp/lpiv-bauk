<script setup>
import {ref} from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
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

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>

        <form @submit.prevent="submit">
<!--            <div class="flex flex-col items-center space-x-2">-->
<!--                <div v-if="preview" class="">-->
<!--                    <img :src="preview" class="w-10 h-10"/>-->
<!--                    <p class="mb-0">file name: {{ image.name }}</p>-->
<!--                    &lt;!&ndash; <p class="mb-0">size: {{ image.size / 1024 }}KB</p>&ndash;&gt;-->
<!--                </div>-->
<!--                <div class="">-->
<!--                    <input id="my-file" accept="image/*"-->
<!--                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"-->
<!--                           type="file"-->
<!--                           @change="previewImage"/>-->
<!--                </div>-->
<!--            </div>-->

            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    v-model="form.name"
                    autocomplete="name"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    v-model="form.email"
                    autocomplete="username"
                    class="mt-1 block w-full"
                    required
                    type="email"
                />

                <InputError :message="form.errors.email" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"/>

                <TextInput
                    id="password"
                    v-model="form.password"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />

                <InputError :message="form.errors.password" class="mt-2"/>
            </div>

            <div class="mt-4">
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

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
