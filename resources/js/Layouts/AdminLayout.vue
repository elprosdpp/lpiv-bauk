<script setup>
import NavSide from "../Components/Dashboard/NavSide.vue";
import ToastList from '@/Components/Toast.vue';

</script>

<template>
    <!--Navbar & Sidebar-->
    <NavSide/>

    <!--Toast-->
    <Transition name="slide-fade">
        <ToastList :message="$page.props.message"/>
    </Transition>

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

<style>
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
