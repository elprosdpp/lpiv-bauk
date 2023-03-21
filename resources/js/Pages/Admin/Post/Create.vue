<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from "@vueform/multiselect";
import Editor from "@tinymce/tinymce-vue"
import {computed, ref} from "vue";

const user = usePage().props.auth.user;

const props = defineProps({
    category: {
        type: Object,
    },
});

const optionStatus = ref(['Publish', 'Draft']);

const preview = ref(null);
const imagePost = ref(null);

const titlePost = ref('');

const slugAble = computed(() => {
    return titlePost.value
        .toLowerCase()
        .replace(/[^a-zA-Z0-9]+/g, "-");
});

const form = useForm({
    user_id: user.id,
    title: titlePost,
    slug: slugAble,
    category: '',
    description: '',
    image: imagePost,
    tags: '',
    status: '',
});

function postStore() {
    router.post(route('post.store'), {
        _method: 'post',
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

const previewImage = (event) => {
    const input = event.target;
    if (input.files) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target.result;
        }
        imagePost.value = input.files[0];
        reader.readAsDataURL(input.files[0]);
    }
};

</script>

<template>

    <Head title="Post Create"/>


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
                <form class="flex flex-col mt-10" @submit.prevent="postStore">
                    <input v-model="form.user_id" hidden type="text">
                    <div class="my-4">
                        <InputLabel for="title" value="Title"/>
                        <TextInput
                            id="title"
                            v-model="titlePost"
                            autocomplete="title"
                            autofocus
                            class="mt-1 block w-full"
                            placeholder="Title Post"
                            type="text"
                        />
                        <InputError :message="form.errors.title" class="mt-2"/>
                    </div>

                    <div class="my-4">
                        <InputLabel for="slug" value="Slug"/>
                        <input id="slug" v-model="slugAble" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" disabled
                               name="slug"
                               placeholder="Automatic generate after type title post"
                               type="text">
                        <InputError :message="form.errors.slug" class="mt-2"/>
                    </div>

                    <div class="my-4">
                        <InputLabel class="mb-2" for="category" value="Category"/>
                        <multiselect
                            v-model="form.category"
                            :options="props.category"
                            placeholder="Select Category">
                        </multiselect>
                        <InputError :message="form.errors.category" class="mt-2"/>
                    </div>

                    <div class="my-4">
                        <InputLabel class="mb-2" value="Description"/>
                        <Editor
                            v-model="form.description"/>
                        <InputError :message="form.errors.description" class="mt-2"/>
                    </div>

                    <div class="my-4">
                        <InputLabel class="mb-2" value="Image Post"/>
                        <div class="flex space-x-4 items-center">
                            <div v-if="preview">
                                <img :src="preview" alt="preview" class="w-56 mb-5 rounded-lg border-2 border-gray-700">
                            </div>
                            <div class="mt-4">
                                <input
                                    id="image"
                                    class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:text-white"
                                    type="file" @change="previewImage"/>
                            </div>
                        </div>
                    </div>
                    <div class="my-4">
                        <InputLabel for="tags" value="Tags (Gunakan tanda (,) jika membuat banyak tags)"/>
                        <TextInput
                            id="tags"
                            v-model="form.tags"
                            class="mt-1 block w-full"
                            placeholder="Tags Post"
                            type="text"
                        />
                        <InputError :message="form.errors.tags" class="mt-2"/>
                    </div>

                    <div class="my-4">
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
