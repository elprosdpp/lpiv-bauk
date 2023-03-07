<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "../Layouts/AdminLayout.vue";
import {ref} from 'vue'
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    DialogDescription,
} from '@headlessui/vue'

const isOpen = ref(true)

function setIsOpen(value) {
    isOpen.value = value
}


</script>

<template>

    <Head title="Posts"></Head>

    <AdminLayout>
        <button
            class="rounded-md bg-black  px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
            type="button">
            Open dialog
        </button>



        <Dialog :open="isOpen" @close="setIsOpen">
            <DialogPanel>
                <DialogTitle>Deactivate account</DialogTitle>
                <DialogDescription>
                    This will permanently deactivate your account
                </DialogDescription>

                <p>
                    Are you sure you want to deactivate your account? All of your data will be
                    permanently removed. This action cannot be undone.
                </p>

                <button @click="setIsOpen(false)">Deactivate</button>
                <button @click="setIsOpen(false)">Cancel</button>
            </DialogPanel>
        </Dialog>
    </AdminLayout>

</template>
