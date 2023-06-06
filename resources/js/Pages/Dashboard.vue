<script setup>
import {Head, router} from '@inertiajs/vue3';
import AdminLayout from "../Layouts/AdminLayout.vue";
import {defineAsyncComponent} from 'vue'
import LoadingCard from '@/Components/LoadingCard.vue';


const Dashboard = defineAsyncComponent({
    loader: () => import("@/Pages/Admin/Dashboard/AsyncDashboard.vue"),
    loadingComponent: LoadingCard,
    delay: 1000,
    timeout: 1000
});

console.log(window.location.pathname)

setInterval(() => {
    location.reload()
}, 1000000)

</script>

<template>
    <Head title="Dashboard"/>

    <AdminLayout>
        <Suspense>
            <template #default>
                <Dashboard/>
            </template>
            <template #fallback>
                <LoadingCard/>
            </template>
        </Suspense>

    </AdminLayout>

</template>
