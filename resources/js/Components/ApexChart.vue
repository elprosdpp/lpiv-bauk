<script setup>
import ApexCharts from 'apexcharts';
import {useDark, useToggle} from "@vueuse/core/index";
import {onMounted} from "vue";

//Dark Mode Vue Use
const isDark = useDark();
const toggleDark = useToggle(isDark);

//Define Props Initialization
const props = defineProps({
    monitorTX: {
        type: Array
    },
    monitorRX: {
        type: Array
    },
    typeChart: {
        type: String
    },
    titleText: {
        type: String
    },
    loadingText: {
        type: String
    },
    heightChart: {
        type: Number
    },
});

//Apex Chart option Configuration
const options = {
    chart: {
        height: props.heightChart,
        type: props.typeChart,
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
        text: props.titleText,
        align: "left"
    },
    noData: {
        text: props.loadingText
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
};

//Mounted Function And Call Chart Module
onMounted(() => {
    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
    setInterval(() => {
        chart.updateSeries([
            {
                name: 'TX Bytes',
                data: props.monitorTX.slice(0, 10)
            },
            {
                name: 'RX Bytes',
                data: props.monitorRX.slice(0, 10)
            }
        ])
    }, 2000)
})
</script>

<template>
    <div id="chart"></div>
</template>

<style lang="css">
.apexcharts-canvas > svg {
    background-color: transparent !important;
}
</style>

