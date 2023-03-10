<script setup>
import Navbar from "../Components/Dashboard/Navbar.vue";
import NavSide from "../Components/Dashboard/NavSide.vue";
import Toast from '@/Components/Toast.vue';

</script>

<template>
    <!--Navbar & Sidebar-->
    <NavSide/>

    <!-- Content -->
    <div id="main-content" class="relative overflow-y-auto lg:ml-64 dark:bg-gray-900">
        <main>
            <!--Toast-->
            <div v-if="$page.props.flash.message" class="absolute right-10 top-10 z-10">
                <Toast :message="$page.props.flash.message"/>
            </div>

            <!--Content here-->
            <div class="p-4 dark:border-gray-700">
                <div class="p-4">
                    <slot/>
                </div>
            </div>
        </main>
    </div>

</template>
