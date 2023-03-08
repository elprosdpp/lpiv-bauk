<script setup>
import Navbar from "../Components/Dashboard/Navbar.vue";
import NavSide from "../Components/Dashboard/NavSide.vue";

</script>

<template>
    <!--Navbar & Sidebar-->
    <NavSide/>

    <!-- Content -->
    <div id="main-content" class="relative h-[100vh] overflow-y-auto lg:ml-64 dark:bg-gray-900">
        <main>
            <div class="p-4 dark:border-gray-700">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                    <slot/>
                </div>
            </div>
        </main>
    </div>

</template>
