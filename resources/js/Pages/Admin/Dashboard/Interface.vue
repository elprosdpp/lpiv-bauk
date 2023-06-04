<script setup>
import {getInterfaces} from "@/Service/Service.js";
import {onMounted, ref, watchEffect} from 'vue'
import ChartComp from '@/Components/Dashboard/ChartComponent.vue'

const int = ref([])

const getInterface = () => {
    getInterfaces()
        .then(response => {
            int.value = response
        })
        .catch(error => console.log(error))
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

// const txFormat = format([txByte]);

onMounted(() => {
    setInterval(getInterface, 1000)
    format()
})
</script>

<template>
    <div class="relative mb-5 overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Tx Byte
                </th>
                <th scope="col" class="px-6 py-3">
                    Rx Byte
                </th>
                <th scope="col" class="px-6 py-3">
                    Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Running
                </th>
            </tr>
            </thead>
            <tbody>
            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700" v-for="int in int" :key="int.id">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ int.name }}
                </th>
                <td class="px-6 py-4">
                    {{ format(int["tx-byte"]) }}
                </td>
                <td class="px-6 py-4">
                    {{ format(int["rx-byte"]) }}
                </td>
                <td class="px-6 py-4">
                    {{ int.type }}
                </td>
                <td class="px-6 py-4">
                    {{ int.running }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="rounded-t-md">
        <div class="p-4 rounded-t-md font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            Interface
        </div>
        <div class="" v-if="int.length">
            <ChartComp :chartLabels="int.map(item => item.name)"
                       :chartDataTX="int.map(item => item['tx-byte']/1024)"
                       :chartDataRX="int.map(item => item['rx-byte']/1024)"/>
        </div>
    </div>
</template>
