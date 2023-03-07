<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    id : user.id,
    name: user.name,
    email: user.email,
    image_profile: null,
});

const preview = ref();
const image = ref();

const previewImage = (event) => {
    const input = event.target;
    if (input.files) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target.result;
        }
        image.value = input.files[0];
        reader.readAsDataURL(input.files[0]);
    }
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form class="mt-6 space-y-6" @submit.prevent="form.patch(route('profile.update'))">
            <div class="" v-if="form.image_profile == null">
                <div v-if="preview" class="">
                    <img :src="form.image_profile ? form.image_profile : preview " class="w-10 h-10"/>
                    <p class="mb-0">file name: {{ image.name }}</p>
                    <!-- <p class="mb-0">size: {{ image.size / 1024 }}KB</p>-->
                </div>
                <div class="mb-4">
                    <input id="my-file" name="image_profile"  accept="image/*"
                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                           type="file"
                           @change="previewImage"/>
                </div>
            </div>
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

            <div>
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

            <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        method="post"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="props.status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition class="transition ease-in-out" enter-from-class="opacity-0" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
