<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from '@inertiajs/vue3';
import {onBeforeUnmount, onMounted, ref, watch, watchEffect} from "vue";
import ApexCharts from "@/Components/ApexChart.vue";
import LoadingCard from "@/Components/LoadingCard.vue";

const monitor = ref([]);
const monitorTX = [];
const monitorRX = [];
const eventSource = ref(null);
const loading = ref(false);
const filter = ref('')


function getURL() {
    const URL = window.location.pathname;
    const split = URL.split('/')
    // console.log(split.pop())
    return filter.value = split.pop()
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


const stream = () => {
    loading.value = true;

    eventSource.value = new EventSource('/admin/interface/stream/' + getURL());
    eventSource.value.onmessage = (event) => {
        // Use event.data to access SSE data received from the server
        monitor.value = JSON.parse(event.data);
        monitorTX.unshift(parseInt(monitor.value["tx_byte"]))
        monitorRX.unshift(parseInt(monitor.value["rx_byte"]))
        loading.value = false;

        // Perform SSE data processing according to your needs
        // console.log(event.data);
    };
}


onMounted(() => {
    stream()
    getURL()
    format()
});

const closeEvent = () => {
    if (eventSource.value) {
        eventSource.value.close();
    }
}

function back() {
    closeEvent()
    router.visit('/admin/interface')
}

onBeforeUnmount(() => {
    closeEvent()
});

// watchEffect(() => {
//     stream()
// });

</script>
<template>

    <Head :title="'Interface Detail | '+ filter"/>


    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="flex space-x-2 items-center">
                    <button type="button" @click="back()"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Kembali
                    </button>
                </div>

                <h1 class="text-white py-10 text-2xl">INTERFACE : <span class="font-bold uppercase">{{ filter }}</span>
                </h1>

                <div class="" v-if="loading">
                    <LoadingCard></LoadingCard>
                </div>

                <div
                    class="grid grid-cols-3 gap-4 mb-4 sm:rounded-lg border-2 p-2 border-gray-100 dark:border-gray-700"
                    v-else>
                    <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="flex items-center mt-4">
                            <div class="mx-14">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-8 h-8 text-gray-500 dark:text-white">
                                    <path fill-rule="evenodd"
                                          d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="-ml-10">
                                <p class="text-gray-500 dark:text-white">Timestamp</p>
                                <p class="text-xl text-gray-400 dark:text-gray-500">{{ monitor["timestamp"] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="flex items-center mt-4">
                            <div class="mx-14">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor"
                                     class="w-8 h-8 text-gray-500 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>

                            </div>
                            <div class="-ml-10">
                                <p class="text-gray-500 dark:text-white">Upload</p>
                                <p class="text-xl text-gray-400 dark:text-gray-500">{{ format(monitor["tx_byte"]) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="flex items-center mt-4">
                            <div class="mx-14">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor"
                                     class="w-8 h-8 text-gray-500 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                </svg>
                            </div>
                            <div class="-ml-10">
                                <p class="text-gray-500 dark:text-white">Download</p>
                                <p class="text-xl text-gray-400 dark:text-gray-500">{{ format(monitor["rx_byte"]) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-10">
                    <ApexCharts :monitorTX="monitorTX" :monitorRX="monitorRX" typeChart="area"
                                :heightChart="parseInt('400')"
                                titleText="Ethernet" loadingText="Loading Data"/>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="css">

.loader-line {
    width: 100%;
    height: 3px;
    /*position: relative;*/
    overflow: hidden;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
}

.loader-line:before {
    content: "";
    position: absolute;
    left: -50%;
    height: 3px;
    width: 40%;
    background-color: #1053da;
    -webkit-animation: lineAnim 1s linear infinite;
    -moz-animation: lineAnim 1s linear infinite;
    animation: lineAnim 1s linear infinite;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
}

@keyframes lineAnim {
    0% {
        left: -40%;
    }
    50% {
        left: 20%;
        width: 80%;
    }
    100% {
        left: 100%;
        width: 100%;
    }
}
</style>

