<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import AdminLayout from "../Layouts/AdminLayout.vue";

import {ref} from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
</script>

<template>
    <Head title="Dashboard"/>

    <!--    <AuthenticatedLayout>-->
    <!--        <template #header>-->
    <!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>-->
    <!--        </template>-->

    <!--        <div class="py-12">-->

    <!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
    <!--                <div v-if="$page.props.flash.message" class="absolute right-10 bottom-10 z-10">-->
    <!--                    <Toast :message="$page.props.flash.message"/>-->
    <!--                </div>-->
    <!--                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">-->
    <!--                    <div class="p-6 text-gray-900">You're logged in!</div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </AuthenticatedLayout>-->

    <AdminLayout>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
                <div class="fixed inset-0 flex items-center justify-center">
                    <button
                        class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                        type="button"
                        @click="openModal"
                    >
                        Open dialog
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>

            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
        </div>

        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto z-40">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900"
                                >
                                    Payment successful
                                </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Your payment has been successfully submitted. We’ve sent you
                                        an email with all of the details of your order.
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="closeModal"
                                    >
                                        Got it, thanks!
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

    </AdminLayout>
</template>
