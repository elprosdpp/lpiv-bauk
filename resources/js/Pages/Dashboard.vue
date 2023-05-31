<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import AdminLayout from "../Layouts/AdminLayout.vue";
// import {clientRosRest} from "@/Service/Service.js";
import {onMounted, ref} from 'vue'
import axios, {AxiosHeaders as Buffer} from "axios";

const permissions = usePage().props.auth.permissions;

const props = defineProps({
    data: {
        type: Object
    },
});

const data = ref('')

const getAddress = () => {
    axios.get("/admin/setting/monitor")
        .then((res) => (
            data.value = res.data
        ))
        .catch((error) => console.log(error))
}

onMounted(() => setInterval(getAddress, 5000))


</script>

<template>
    <Head title="Dashboard"/>

    <AdminLayout>
        <div class="grid grid-cols-3 gap-4 mb-4 ">
            <p class="text-white" id="data" v-for="data in data" :key="data.id">{{ data }}</p>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div
                class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
            </div>
        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
        </div>
        <button
            v-for="per in permissions"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button">
            {{ per }}
        </button>


    </AdminLayout>
</template>
