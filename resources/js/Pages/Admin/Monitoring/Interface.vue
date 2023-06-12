<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from '@inertiajs/vue3';
import {onBeforeUnmount, onMounted, ref, watch, watchEffect} from "vue";
import {getInterfaces} from "@/Service/Service";
import ApexCharts from 'apexcharts';
import {useDark, useToggle} from "@vueuse/core/index";

const isDark = useDark();
const toggleDark = useToggle(isDark);

const monitor = ref([]);
const monitorTX = [];
const monitorRX = [];
const labels = [];
const eventSource = ref(null);
const loading = ref(false);
const filter = ref('')
const int = ref([])

// const changeItem = (event) => {
//     filter.value = event;
//     if (eventSource.value) {
//         eventSource.value.close();
//     }
// };

function getURL() {
    const URL = window.location.pathname;
    const split = URL.split('/')
    // console.log(split.pop())
    return filter.value = split.pop()
}


const stream = () => {
    loading.value = true;

    eventSource.value = new EventSource('/admin/interface/stream/' + filter.value);
    eventSource.value.onmessage = (event) => {
        // Menggunakan event.data untuk mengakses data SSE yang diterima dari server
        monitor.value = JSON.parse(event.data);
        monitorTX.unshift(parseInt(monitor.value["tx_byte"]))
        monitorRX.unshift(parseInt(monitor.value["rx_byte"]))
        labels.unshift(monitor.value["timestamp"])
        loading.value = false;

        // Lakukan pemrosesan data SSE sesuai kebutuhan Anda
        // console.log(event.data);
    };
}


const getInterface = () => {
    getInterfaces()
        .then(response => {
            int.value = response
        })
        .catch(error => console.log(error))
}

const options = {
    chart: {
        height: 500,
        type: 'area',
        background: 'rgba(2,2,2,0.5)',
    },
    dataLabels: {
        enabled: false
    },
    theme: {
        mode: toggleDark ? "dark" : "light",
        palette: 'palette1',
    },
    title: {
        text: 'Ethernet',
        align: "left"
    },
    noData: {
        text: 'Loading...'
    },
    series: [
        {
            name: 'sales',
            data: []
        }, {
            name: 'sales',
            data: []
        }
    ],
    xaxis: {
        labels: {
            show: false
        }
    },
}

onMounted(() => {
    stream()
    getInterface()
    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
    setInterval(() => {
        chart.updateSeries([
            {
                name: 'TX Bytes',
                data: monitorTX.slice(0, 10)
            },
            {
                name: 'RX Bytes',
                data: monitorRX.slice(0, 10)
            }
        ])
    }, 2000)
    getURL()
});

const closeEvent = () => {
    if (eventSource.value) {
        eventSource.value.close();
    }
}

function back() {
    router.visit('/admin/interface')
    closeEvent()
}

onBeforeUnmount(() => {
    closeEvent()
});

watchEffect(() => {
    stream()
});

</script>
<template>

    <Head :title="'Interface Detail | '+ filter"/>


    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <!--                <select-->
                <!--                    @change="changeItem($event.target.value)"-->
                <!--                    class="bg-gray-50 my-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-4 lg:ml-5 lg:my-0"-->
                <!--                >-->
                <!--                    <option value="">Ethernet</option>-->
                <!--                    <option v-for="item in int" :key="item.id" :value="item.name">-->
                <!--                        {{ item.name }}-->
                <!--                    </option>-->
                <!--                </select>-->
                <div class="flex space-x-2 items-center">
                    <!--                    <Link :href="route('post.create')"-->
                    <!--                          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"-->
                    <!--                    >-->
                    <!--                        Tambah Interface-->
                    <!--                    </Link>-->
                    <button type="button" @click="back()"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Kembali
                    </button>
                </div>

                <div class="py-10">
                    <p class="text-white" v-if="loading">.......</p>
                    <p class="text-white" v-else>{{ monitor }} | {{ monitor["tx_byte"] }}</p>
                </div>

                <div class="py-10">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="css">
.apexcharts-canvas > svg {
    background-color: transparent !important;
}
</style>
