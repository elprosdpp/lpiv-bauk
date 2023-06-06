<script setup>
import Chart from 'chart.js/auto';
import {onMounted, ref} from "vue";
import {getEtherOnes} from "@/Service/Service.js";

const data = {
    labels: ['Ether'],
    datasets: [
        {
            label: 'TX Byte',
            data: [],
            borderWidth: 3
        },
        {
            label: 'RX Byte',
            data: [],
            borderWidth: 3
        }
    ]
}

const config = {
    type: 'bar',
    data: data,
    options: {
        scales: {
            x: {
                display: true
            },
            y: {
                display: true
            }
        }
    }
}

onMounted(() => {
    const etherChart = new Chart(document.getElementById('ether'), config);

    const getEtherOne = () => {
        getEtherOnes()
            .then(response => {
                // data.labels = response[0].name
                data.datasets[0].data = response[0]['tx-bits-per-second']
                data.datasets[1].data = response[0]['rx-bits-per-second']
                etherChart.update()
            })
            .catch(error => console.log(error))
    }
    // getEtherOne();

    setInterval(() => {
        getEtherOne();
    }, 1000);

})

</script>

<template>
    <!--    <div class="" v-if="data.value.datasets[0].data">-->
    <canvas id="ether"></canvas>
    <!--    </div>-->
</template>
