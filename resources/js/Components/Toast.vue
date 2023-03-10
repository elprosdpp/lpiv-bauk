<script setup>

import {ref, defineProps, onMounted} from 'vue';

const props = defineProps({
    message: String
})

const showNotification = ref(false);

onMounted(() => {
    showNotification.value = true;
    setTimeout(() => (showNotification.value = false), 5000);
});

</script>

<template>
    <Transition name="slide-fade">
        <div v-if="message && showNotification" class="max-w-2xl">
            <div id="toast-default"
                 class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg border-b-2 border-indigo-400 shadow dark:bg-blue-900"
                 role="alert">
                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg ">
                    <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                              stroke-linejoin="round">
                        </path>
                    </svg>
                </div>
                <div class="ml-3 text-sm font-bold dark:text-white">{{ message }} !</div>
            </div>
        </div>
    </Transition>
</template>

<style lang="css">
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>
