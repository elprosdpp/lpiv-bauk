<script setup>
import {getInterfaces, getEtherOnes} from "@/Service/Service.js";
import {onMounted, ref} from 'vue'
import ChartComp from '@/Components/Dashboard/ChartComponent.vue'
import EtherComp from '@/Pages/Admin/Dashboard/Ethernet.vue'
import axios from "axios";

const int = ref([])
const ether = ref()
const ether1 = ref([])

const getInterface = () => {
    getInterfaces()
        .then(response => {
            int.value = response
        })
        .catch(error => console.log(error))
}

const getEtherOne = () => {
    getEtherOnes()
        .then(response => {
            ether.value = response[0]['tx-bits-per-second']
            ether1.value = response
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

const token = '5674683976:AAHH4vxSsjTGs8IhM-dxbQHVHNwMKVUoYnE'
const chatId = '1252436667'
const message = "😊 Data Ether 2 Lebih Dari 90Kbps"

function submitForm() {
    axios({
        method: 'post',
        url: `https://api.telegram.org/bot${token}/sendMessage`,
        data: {
            chat_id: chatId,
            text: message,
            parse_mode: 'html',
        },
        headers: {"Content-Type": "application/json"},
    }).then(response => {
        console.log(response)
    }).catch(error => {
        console.log(error)
    })
}


function sendAlert() {
    if (ether) {
        if (parseInt(ether.value) >= 90000) {
            submitForm()
        } else {

        }
    }
}

const queryURL = ref('/admin/dashboard');

if (window.location.pathname == queryURL.value) {
    setInterval(function () {
        getEtherOne()
    }, 1000);

    setInterval(function () {
        sendAlert()
    }, 10000);
    
    setInterval(getInterface, 1000)
}

onMounted(() => {
    format()
})
</script>

<template>

    <p class="text-white" v-if="ether">Ether 2 : {{ ether }} |
        {{ format(ether) }}</p>
    <div class="mb-5 sm:rounded-lg border-2 p-2 border-gray-100 dark:border-gray-700">
        <div
            class="p-4 rounded-t-md font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            Interface
        </div>
        <div class="rounded-t-md grid grid-cols-3 gap-4 justify-between">
            <div class="col-span-2" v-if="int.length">
                <ChartComp :chartLabels="int.map(item => item.name)"
                           :chartDataTX="int.map(item => item['tx-byte']/1024)"
                           :chartDataRX="int.map(item => item['rx-byte']/1024)"/>
            </div>
            <div class="pt-5">
                <table class="text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="border-b-2 border-gray-700">
                    <tr>
                        <th scope="col" class="px-5 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-5 py-3">
                            Tx Byte
                        </th>
                        <th scope="col" class="px-5 py-3">
                            Rx Byte
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700" v-for="int in int"
                        :key="int.id">
                        <th scope="row" class="px-5 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ int.name }}
                        </th>
                        <td class="px-5 py-3">
                            {{ format(int["tx-byte"]) }}
                        </td>
                        <td class="px-5 py-3">
                            {{ format(int["rx-byte"]) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4-">
        <div class="" v-if="ether">
            <!--            <ChartComp :chartLabels="['Test']" :chartDataTX="[ether]" :chartDataRX="['15']" chartType="bar"/>-->
            <EtherComp></EtherComp>
        </div>
    </div>
</template>
