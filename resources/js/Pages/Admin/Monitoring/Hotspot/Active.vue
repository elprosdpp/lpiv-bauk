<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {onBeforeUnmount, onMounted, ref} from "vue";

// const props = defineProps({
//     activeHotspot: {
//         type: Array,
//         default: () => ([]),
//     },
// })

const eventSource = ref(null);
const loading = ref(false);
const monitorHotspot = ref(false);


const stream = () => {
    loading.value = true;

    eventSource.value = new EventSource('/admin/hotspot/user/StreamActiveHotspot');
    eventSource.value.onmessage = (event) => {
        // Use event.data to access SSE data received from the server
        monitorHotspot.value = JSON.parse(event.data);
        loading.value = false;

        // Perform SSE data processing according to your needs
        // console.log(event.data);
    };
}

function format(speed) {
    const satuan = ['bytes', 'Kb', 'Mb', 'Gb', 'Tb'];
    let i = 0;
    while (speed > 1024) {
        speed /= 1024;
        i++
    }
    return parseFloat(speed).toFixed(1) + ' ' + satuan[i];
}

onMounted(() => {
    stream()
    format()
});

const closeEvent = () => {
    if (eventSource.value) {
        eventSource.value.close();
    }
}

function back() {
    closeEvent()
    router.visit('/admin/hotspot')
}

onBeforeUnmount(() => {
    closeEvent()
});
</script>

<template>

    <Head title="Hotspot Active"/>


    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="overflow-hidden sm:rounded-lg">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2 items-center">
                            <button type="button" @click="back()"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Kembali
                            </button>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"></path>
                                </svg>
                            </div>
                            <!--                            <input v-model="search"-->
                            <!--                                   class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"-->
                            <!--                                   placeholder="Search Users..."-->
                            <!--                                   required type="search">-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="text-white" v-if="loading">Loading...</div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" v-else>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="py-3 px-6" scope="col">User</th>
                            <th class="py-3 px-6" scope="col">Address</th>
                            <th class="py-3 px-6" scope="col">Uptime</th>
                            <th class="py-3 px-6" scope="col">RX/TX</th>
                            <!--                            <th v-if="can.edit || can.delete" class="py-3 px-6" scope="col">Actions</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="active in monitorHotspot['data']" :key="active['.id']"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6" data-label="Title">
                                {{ active['user'] }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ active['address'] }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ active['uptime'] }}
                            </td>
                            <td class="py-4 px-6" data-label="Title">
                                {{ format(active["bytes-in"]) }} / {{ format(active['bytes-out']) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>


