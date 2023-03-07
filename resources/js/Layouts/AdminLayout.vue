<script setup>
import Navbar from "../Components/Dashboard/Navbar.vue";
import Sidebar from "../Components/Dashboard/Sidebar.vue";

</script>

<template>
    <!--Navbar-->
    <Navbar/>

    <!--Sidebar-->
    <Sidebar/>

    <!-- Content -->
    <div id="sidebarBackdrop" class="fixed inset-0 z-10 hidden dark:bg-gray-900/90"></div>
    <div id="main-content" class="relative h-full overflow-y-auto lg:ml-64 dark:bg-gray-900">
        <main>
            <div class="p-4">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                    <slot/>
                </div>
            </div>
        </main>
    </div>

</template>
