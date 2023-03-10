<script setup>
import NavSide from "../Components/Dashboard/NavSide.vue";
import Toast from '@/Components/Toast.vue';

</script>

<template>
    <!--Navbar & Sidebar-->
    <NavSide/>

    <!--Toast-->
    <div v-if="$page.props.flash.message" class="fixed right-10 top-[6rem] z-[999]">
        <Toast :message="$page.props.flash.message"/>
    </div>

    <!-- Content -->
    <div id="main-content" class="relative overflow-y-auto lg:ml-64 dark:bg-gray-900">
        <main>
            <!--Content here-->
            <div class="p-4 dark:border-gray-700">
                <div class="p-4">
                    <slot/>
                </div>
            </div>
        </main>
    </div>

</template>
