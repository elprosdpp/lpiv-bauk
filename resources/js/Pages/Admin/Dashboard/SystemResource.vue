<script setup>
import {getResources} from "@/Service/Service.js";
import {onBeforeMount, onMounted, ref, watchEffect} from 'vue'

const data = ref('');
const loading = ref(false);

const getResource = () => {
    getResources()
        .then(response => {
            data.value = response
        })
        .catch(error => {
            loading.value = true
        })
}


onBeforeMount(() => {
    setTimeout(getResources, 1000)
})

watchEffect(() => setInterval(getResource, 5000));
</script>

<template>
    <div class="grid grid-cols-3 gap-4 mb-4" v-for="data in data" :key="data.id">
        <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="absolute top-[34px] z-[99] w-[30%]">
                <div :class="loading ? 'loader-line mb-5': 'mb-5'"></div>
            </div>

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
                    <p class="text-gray-500 dark:text-white">Uptime</p>
                    <p class="text-2xl text-gray-400 dark:text-gray-500">{{ data["uptime"] }}</p>
                </div>
            </div>
        </div>
        <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="absolute top-[34px] z-[99] w-[30%]">
                <div :class="loading ? 'loader-line mb-5': 'mb-5'"></div>
                <!--                    <div class="loader-line"></div>-->
            </div>

            <div class="flex items-center mt-4">
                <div class="mx-14">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-8 h-8 text-gray-500 dark:text-white">
                        <path d="M16.5 7.5h-9v9h9v-9z"/>
                        <path fill-rule="evenodd"
                              d="M8.25 2.25A.75.75 0 019 3v.75h2.25V3a.75.75 0 011.5 0v.75H15V3a.75.75 0 011.5 0v.75h.75a3 3 0 013 3v.75H21A.75.75 0 0121 9h-.75v2.25H21a.75.75 0 010 1.5h-.75V15H21a.75.75 0 010 1.5h-.75v.75a3 3 0 01-3 3h-.75V21a.75.75 0 01-1.5 0v-.75h-2.25V21a.75.75 0 01-1.5 0v-.75H9V21a.75.75 0 01-1.5 0v-.75h-.75a3 3 0 01-3-3v-.75H3A.75.75 0 013 15h.75v-2.25H3a.75.75 0 010-1.5h.75V9H3a.75.75 0 010-1.5h.75v-.75a3 3 0 013-3h.75V3a.75.75 0 01.75-.75zM6 6.75A.75.75 0 016.75 6h10.5a.75.75 0 01.75.75v10.5a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V6.75z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="-ml-10">
                    <p class="text-gray-500 dark:text-white">CPU Load</p>
                    <p class="text-2xl text-gray-400 dark:text-gray-500">{{ data["cpu-load"] }} %</p>
                </div>
            </div>
        </div>
        <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="absolute top-[34px] z-[99] w-[30%]">
                <div :class="loading ? 'loader-line mb-5': 'mb-5'"></div>
                <!--                    <div class="loader-line"></div>-->
            </div>

            <div class="flex items-center mt-4">
                <div class="mx-14">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-8 h-8 text-gray-500 dark:text-white">
                        <path
                            d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875z"/>
                        <path
                            d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 001.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 001.897 1.384C6.809 12.164 9.315 12.75 12 12.75z"/>
                        <path
                            d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 001.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 001.897 1.384C6.809 15.914 9.315 16.5 12 16.5z"/>
                        <path
                            d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 001.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 001.897 1.384C6.809 19.664 9.315 20.25 12 20.25z"/>
                    </svg>

                </div>
                <div class="-ml-10">
                    <p class="text-gray-500 dark:text-white">Total HDD Space</p>
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        {{
                            Math.round(data["total-hdd-space"] / 1073741824)
                        }} GiB
                    </p>
                </div>
            </div>
        </div>
        <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="absolute top-[34px] z-[99] w-[30%]">
                <div :class="loading ? 'loader-line mb-5': 'mb-5'"></div>
                <!--                    <div class="loader-line"></div>-->
            </div>

            <div class="flex items-center mt-4">
                <div class="mx-14">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-8 h-8 text-gray-500 dark:text-white">
                        <path fill-rule="evenodd"
                              d="M2.25 5.25a3 3 0 013-3h13.5a3 3 0 013 3V15a3 3 0 01-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 01-.53 1.28h-9a.75.75 0 01-.53-1.28l.621-.622a2.25 2.25 0 00.659-1.59V18h-3a3 3 0 01-3-3V5.25zm1.5 0v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5z"
                              clip-rule="evenodd"/>
                    </svg>

                </div>
                <div class="-ml-10">
                    <p class="text-gray-500 dark:text-white">Architecture Name</p>
                    <p class="text-2xl text-gray-400 dark:text-gray-500">{{ data["architecture-name"] }}</p>
                </div>
            </div>
        </div>
        <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="absolute top-[34px] z-[99] w-[30%]">
                <div :class="loading ? 'loader-line mb-5': 'mb-5'"></div>
                <!--                    <div class="loader-line"></div>-->
            </div>

            <div class="flex items-center mt-4">
                <div class="mx-14">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-8 h-8 text-gray-500 dark:text-white">
                        <path d="M16.5 7.5h-9v9h9v-9z"/>
                        <path fill-rule="evenodd"
                              d="M8.25 2.25A.75.75 0 019 3v.75h2.25V3a.75.75 0 011.5 0v.75H15V3a.75.75 0 011.5 0v.75h.75a3 3 0 013 3v.75H21A.75.75 0 0121 9h-.75v2.25H21a.75.75 0 010 1.5h-.75V15H21a.75.75 0 010 1.5h-.75v.75a3 3 0 01-3 3h-.75V21a.75.75 0 01-1.5 0v-.75h-2.25V21a.75.75 0 01-1.5 0v-.75H9V21a.75.75 0 01-1.5 0v-.75h-.75a3 3 0 01-3-3v-.75H3A.75.75 0 013 15h.75v-2.25H3a.75.75 0 010-1.5h.75V9H3a.75.75 0 010-1.5h.75v-.75a3 3 0 013-3h.75V3a.75.75 0 01.75-.75zM6 6.75A.75.75 0 016.75 6h10.5a.75.75 0 01.75.75v10.5a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V6.75z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="-ml-10">
                    <p class="text-gray-500 dark:text-white">CPU</p>
                    <p class="text-2xl text-gray-400 dark:text-gray-500">{{ data["cpu"] }}</p>
                </div>
            </div>
        </div>
        <div class="h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="absolute top-[34px] z-[99] w-[30%]">
                <div :class="loading ? 'loader-line mb-5': 'mb-5'"></div>
                <!--                    <div class="loader-line"></div>-->
            </div>

            <div class="flex items-center mt-4">
                <div class="mx-14">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-8 h-8 text-gray-500 dark:text-white">
                        <path fill-rule="evenodd"
                              d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                              clip-rule="evenodd"/>
                    </svg>

                </div>
                <div class="-ml-10">
                    <p class="text-gray-500 dark:text-white">Board Name | Version</p>
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        {{ data["board-name"] }} |
                        {{ data["version"] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
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
