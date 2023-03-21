<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from "@vueform/multiselect";
import {ref} from "vue";

// const user = usePage().props.auth.user;

const props = defineProps({
    post: {
        type: Object
    },
    category: {
        type: Object,
    },
});

const optionStatus = ref(['Publish', 'Draft']);

const form = useForm({
    user_id: props.post.user_id,
    title: props.post.title,
    slug: props.post.slug,
    category: props.post.category,
    description: props.post.description,
    image: props.post.image,
    tags: props.post.tags,
    status: props.post.status,
});

function postUpdate() {
    router.post(`/admin/post/${props.post.id}`, {
        _method: 'put',
        user_id: form.user_id,
        title: form.title,
        slug: form.slug,
        category: form.category,
        description: form.description,
        image: form.image,
        tags: form.tags,
        status: form.status,
    })
}

</script>

<template>

    <Head title="Post Edit"/>


    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <!--Route Back Post Index-->
                <Link :href="route('post.index')"
                      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    <svg aria-hidden="true" class="w-4 h-4 inline-flex" fill="none" stroke="currentColor"
                         stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" stroke-linecap="round"
                              stroke-linejoin="round"></path>
                    </svg>
                    Back
                </Link>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <form class="flex flex-col mt-10" @submit.prevent="postUpdate">
                    <input v-model="form.user_id" hidden type="text">
                    <div class="mb-5">
                        <InputLabel for="title" value="Title"/>
                        <TextInput
                            id="title"
                            v-model="form.title"
                            autocomplete="name"
                            autofocus
                            class="mt-1 block w-full"
                            type="text"
                        />
                        <InputError :message="form.errors.title" class="mt-2"/>
                    </div>

                    <div class="mb-5">
                        <InputLabel for="slug" value="Slug"/>
                        <TextInput
                            id="slug"
                            v-model="form.slug"
                            class="mt-1 block w-full"
                            type="text"
                        />
                        <InputError :message="form.errors.slug" class="mt-2"/>
                    </div>

                    <div class="mb-5">
                        <InputLabel class="mb-2" for="category" value="Category"/>
                        <multiselect
                            v-model="form.category"
                            :options="props.category"
                            placeholder="Select Category">
                        </multiselect>
                        <InputError :message="form.errors.category" class="mt-2"/>
                    </div>

                    <div class="mb-5">
                        <textarea id="description" v-model="form.description" cols="30" name="description"
                                  rows="10"></textarea>
                        <InputError :message="form.errors.description" class="mt-2"/>
                    </div>

                    <div class="flex space-x-4 items-center mt-10 mb-5">
                        <img :src="`/storage/`+ props.post?.image" alt=""
                             class="w-48 mb-5 rounded-lg border-2 border-gray-700">
                        <div class="mt-4">
                            <InputLabel for="image" value="Profile"/>

                            <input
                                id="image"
                                class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:text-white"
                                type="file" @input="form.image = $event.target.files[0]"/>
                        </div>
                    </div>

                    <div class="mb-5">
                        <InputLabel for="tags" value="Tags"/>
                        <TextInput
                            id="tags"
                            v-model="form.tags"
                            class="mt-1 block w-full"
                            type="text"
                        />
                        <InputError :message="form.errors.tags" class="mt-2"/>
                    </div>

                    <div class="mb-5">
                        <InputLabel class="mb-2" for="status" value="Status"/>
                        <multiselect
                            v-model="form.status"
                            :options="optionStatus"
                            placeholder="Select Status">
                        </multiselect>
                        <InputError :message="form.errors.status" class="mt-2"/>
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

<!--CSS Render MultiSelect @VueForm-->
<style src="@vueform/multiselect/themes/default.css"></style>
