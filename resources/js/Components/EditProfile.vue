<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm, usePage, router} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {ref} from "vue";

const user = usePage().props.auth.user;

const form = useForm({
    id: user.id,
    name: user.name,
    email: user.email,
    image_profile: null,
});


function updateAvatar() {
    router.post(`/updateProfil/${user.id}`, {
        _method: 'put',
        id: form.id,
        name: form.name,
        email: form.email,
        image_profile: form.image_profile
    })
}


// const preview = ref();
// const image = ref();

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

    <form class="flex flex-col" @submit.prevent="updateAvatar">

        <div class="flex space-x-4 items-center">
            <img :src="`/storage/`+ user?.image_profile" alt="" class="w-48 mb-5 rounded-lg border-2 border-gray-700">
            <div class="mt-4">
                <InputLabel for="ImageProfil" value="Profile"/>

                <input
                    id="ImageProfil"
                    class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    name="image_profile"
                    type="file" @input="form.image_profile = $event.target.files[0]"/>
            </div>
        </div>
        <div>
            <input v-model="form.id" hidden type="text"/>
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
                autocomplete="email"
                autofocus
                class="mt-1 block w-full"
                required
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
</template>
