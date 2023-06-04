<script setup>
import Chart from 'chart.js/auto';
import {onMounted} from "vue";

const props = defineProps({
    chartLabel: {
        type: String
    },
    chartLabels: {
        type: Array
    },
    chartType: {
        type: String,
        default: 'line'
    },
    chartDataTX: {
        type: Array,
    },
    chartDataRX: {
        type: Array,
    }
})

// const ctx = document.getElementById('myChart');

const data = {
    labels: props.chartLabels,
    datasets: [
        {
            label: 'TX Byte',
            data: props.chartDataTX,
            borderWidth: 3
        },
        {
            label: 'RX Byte',
            data: props.chartDataRX,
            borderWidth: 3
        }
    ]
}

const config = {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Datasets = /1024',
            }
        }
    }
}

onMounted(() => {
    return new Chart(document.getElementById('myChart'), config)
})

</script>

<template>
    <canvas id="myChart"></canvas>
</template>
