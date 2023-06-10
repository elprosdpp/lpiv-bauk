<script setup>
import {ref} from 'vue';
import {useDark, useToggle} from '@vueuse/core';
import {Head, Link, useForm, usePage, router} from '@inertiajs/vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ResponsiveSideLink from '@/Components/ResponsiveSideLink.vue';
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue';


const isOpen = ref(false);
const isProfile = ref(false);
const Sidebar = ref(false);

const user = usePage().props.auth.user;
const role = usePage().props.auth.roles[0];

const isDark = useDark();
const toggleDark = useToggle(isDark);

function closeModal() {
    isOpen.value = false;
}

function openModal() {
    isOpen.value = true;
}

</script>

<template>
    <nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button id="toggleSidebarMobile" aria-controls="sidebar" aria-expanded="true"
                            class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            @click="Sidebar = !Sidebar">
                        <svg v-if="!Sidebar" id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor"
                             viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                  fill-rule="evenodd"></path>
                        </svg>
                        <svg v-if="Sidebar" id="toggleSidebarMobileClose" class="w-6 h-6" fill="currentColor"
                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  fill-rule="evenodd"></path>
                        </svg>
                    </button>
                    <a class="flex ml-2 md:mr-24" href="#">
                        <img alt="FlowBite Logo" class="h-8 mr-3"
                             src="https://flowbite-admin-dashboard.vercel.app/images/logo.svg">
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Flowbite</span>
                    </a>
                    <form action="#" class="hidden lg:block lg:pl-3.5" method="GET">
                        <label class="sr-only" for="topbar-search">Search</label>
                        <div class="relative mt-1 lg:w-96">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          fill-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="topbar-search"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   name="email"
                                   placeholder="Search"
                                   type="text">
                        </div>
                    </form>
                </div>
                <div class="flex items-center">
                    <button id="theme-toggle"
                            class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5"
                            data-tooltip-target="tooltip-toggle"
                            type="button"
                            @click="toggleDark()">
                        <svg
                            v-if="!isDark"
                            class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg v-if="isDark"
                             class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                clip-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </button>

                    <div class="flex items-center ml-3">
                        <div>
                            <button
                                id="user-menu-button-2"
                                aria-expanded="false"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                data-dropdown-toggle="dropdown-2"
                                type="button" @click="isProfile = !isProfile">
                                <span class="sr-only">Open user menu</span>
                                <img :src="`/storage/`+ user.image_profile"
                                     alt="user photo"
                                     class="w-8 h-8 rounded-full"/>
                            </button>
                        </div>

                        <div
                            v-show="isProfile"
                            class="z-50  my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            data-popper-placement="bottom"
                            style="position: absolute; top: 3rem; right: 15px">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ user.name }}
                                </p>
                                <p class="text-xs font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ user.email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li @click="isProfile = !isProfile">
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#"
                                       role="menuitem">Profile</a>
                                </li>
                                <li @click="isProfile = !isProfile">
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#"
                                       role="menuitem">Settings</a>
                                </li>
                                <li @click="isProfile = !isProfile">
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#"
                                       role="menuitem">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div id="sidebarBackdrop"
         :class="Sidebar ? 'fixed inset-0 z-10 bg-gray-500/50 dark:bg-gray-900/50' : 'fixed hidden inset-0 z-10 bg-gray-500/50 dark:bg-gray-900/50'"></div>

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        <aside id="sidebar"
               :class="Sidebar ? 'fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width' : 'fixed top-0 left-0 z-20 flex flex-col hidden flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width'"
               aria-label="Sidebar">
            <div
                class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                    <div
                        class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <ul class="pb-2 space-y-2">
                            <li>
                                <form action="#" class="lg:hidden" method="GET">
                                    <label class="sr-only" for="mobile-search">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path clip-rule="evenodd"
                                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                      fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input id="mobile-search"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                               name="email"
                                               placeholder="Search"
                                               type="text">
                                    </div>
                                </form>
                            </li>
                            <li>
                                <!--                                <Link-->
                                <!--                                    :href="route('dashboard')" -->
                                <!--                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">-->
                                <!--                                    <svg-->
                                <!--                                        class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"-->
                                <!--                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">-->
                                <!--                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>-->
                                <!--                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>-->
                                <!--                                    </svg>-->
                                <!--                                    <span class="ml-3" sidebar-toggle-item="">Dashboard</span>-->
                                <!--                                </Link>-->
                                <ResponsiveSideLink :active="route().current('dashboard')" :href="route('dashboard')">
                                    <svg
                                        :class="route().current('dashboard') ? 'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900 dark:text-gray-100 dark:group-hover:text-white' : 'w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white'"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                    </svg>
                                    <span class="ml-3" sidebar-toggle-item="">Dashboard</span>
                                </ResponsiveSideLink>
                            </li>
                            <li v-if="role === 'super-admin'">
                                <Disclosure>
                                    <DisclosureButton
                                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg
                                            aria-hidden="true"
                                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zM6 8a2 2 0 11-4 0 2 2 0 014 0zM1.49 15.326a.78.78 0 01-.358-.442 3 3 0 014.308-3.516 6.484 6.484 0 00-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 01-2.07-.655zM16.44 15.98a4.97 4.97 0 002.07-.654.78.78 0 00.357-.442 3 3 0 00-4.308-3.517 6.484 6.484 0 011.907 3.96 2.32 2.32 0 01-.026.654zM18 8a2 2 0 11-4 0 2 2 0 014 0zM5.304 16.19a.844.844 0 01-.277-.71 5 5 0 019.947 0 .843.843 0 01-.277.71A6.975 6.975 0 0110 18a6.974 6.974 0 01-4.696-1.81z"></path>
                                        </svg>
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="">Management</span>
                                        <svg class="w-6 h-6" fill="currentColor" sidebar-toggle-item=""
                                             viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  fill-rule="evenodd"></path>
                                        </svg>
                                    </DisclosureButton>
                                    <DisclosurePanel class="space-y-2 py-2">
                                        <ul>
                                            <li>
                                                <ResponsiveNavLink :active="route().current('role.index')"
                                                                   :href="route('role.index')">
                                                    Role
                                                </ResponsiveNavLink>
                                            </li>
                                            <li>
                                                <ResponsiveNavLink :active="route().current('permission.index')"
                                                                   :href="route('permission.index')">
                                                    Permission
                                                </ResponsiveNavLink>
                                            </li>
                                            <li>
                                                <ResponsiveNavLink :active="route().current('users.index')"
                                                                   :href="route('users.index')">
                                                    User
                                                </ResponsiveNavLink>
                                            </li>
                                        </ul>
                                    </DisclosurePanel>
                                </Disclosure>
                            </li>
                            <li v-if="role === 'super-admin'">
                                <Disclosure>
                                    <DisclosureButton
                                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor"
                                             class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                                        </svg>

                                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="">Monitoring</span>
                                        <svg class="w-6 h-6" fill="currentColor" sidebar-toggle-item=""
                                             viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  fill-rule="evenodd"></path>
                                        </svg>
                                    </DisclosureButton>
                                    <DisclosurePanel class="space-y-2 py-2">
                                        <ul>
                                            <li>
                                                <ResponsiveNavLink :active="route().current('interface.index')"
                                                                   :href="route('interface.index')">
                                                    Interface
                                                </ResponsiveNavLink>
                                            </li>
                                            <li>
                                                <ResponsiveNavLink :active="route().current('permission.index')"
                                                                   :href="route('permission.index')">
                                                    Hotspot
                                                </ResponsiveNavLink>
                                            </li>
                                            <li>
                                                <ResponsiveNavLink :active="route().current('users.index')"
                                                                   :href="route('users.index')">
                                                    IP Address
                                                </ResponsiveNavLink>
                                            </li>
                                        </ul>
                                    </DisclosurePanel>
                                </Disclosure>
                            </li>
                            <li>
                                <ResponsiveSideLink :active="route().current('category.index')"
                                                    :href="route('category.index')">
                                    <svg
                                        :class="route().current('category.index') ? 'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900 dark:text-gray-100 dark:group-hover:text-white' : 'w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white'"
                                        aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd"
                                              d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z"
                                              fill-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-3" sidebar-toggle-item="">Category</span>
                                </ResponsiveSideLink>
                            </li>
                            <li>
                                <ResponsiveSideLink :active="route().current('post.index')" :href="route('post.index')">
                                    <svg
                                        :class="route().current('post.index') ? 'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900 dark:text-gray-100 dark:group-hover:text-white' : 'w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white'"
                                        aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd"
                                              d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z"
                                              fill-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-3" sidebar-toggle-item="">Post</span>
                                </ResponsiveSideLink>
                            </li>
                            <li>
                                <ResponsiveSideLink :active="route().current('setting.index')"
                                                    :href="route('setting.index')">
                                    <svg
                                        :class="route().current('setting.index') ? 'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900 dark:text-gray-100 dark:group-hover:text-white hover:animate-spin' : 'w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white hover:animate-spin'"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6">
                                        <path fill-rule="evenodd"
                                              d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                                              clip-rule="evenodd"/>
                                    </svg>

                                    <span class="ml-3" sidebar-toggle-item="">Setting</span>
                                </ResponsiveSideLink>
                            </li>
                        </ul>

                        <!-- Logout Button-->
                        <div class="pt-2 space-y-2">
                            <button
                                class="flex w-full items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700"
                                @click="openModal">
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                    fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd"
                                          d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z"
                                          fill-rule="evenodd"></path>
                                    <path clip-rule="evenodd"
                                          d="M19 10a.75.75 0 00-.75-.75H8.704l1.048-.943a.75.75 0 10-1.004-1.114l-2.5 2.25a.75.75 0 000 1.114l2.5 2.25a.75.75 0 101.004-1.114l-1.048-.943h9.546A.75.75 0 0019 10z"
                                          fill-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3" sidebar-toggle-item="">Logout</span>
                            </button>
                        </div>

                        <!-- Modal Dialog-->
                        <TransitionRoot :show="isOpen" appear as="template">
                            <Dialog as="div" class="relative z-50" @close="closeModal">
                                <TransitionChild
                                    as="template"
                                    enter="duration-300 ease-out"
                                    enter-from="opacity-0"
                                    enter-to="opacity-100"
                                    leave="duration-200 ease-in"
                                    leave-from="opacity-100"
                                    leave-to="opacity-0"
                                >
                                    <div class="fixed inset-0 bg-black bg-opacity-30"/>
                                </TransitionChild>

                                <div class="fixed inset-0 overflow-y-auto z-40">
                                    <div
                                        class="flex min-h-full items-center justify-center p-4 text-center">
                                        <TransitionChild
                                            as="template"
                                            enter="duration-300 ease-out"
                                            enter-from="opacity-0 scale-95"
                                            enter-to="opacity-100 scale-100"
                                            leave="duration-200 ease-in"
                                            leave-from="opacity-100 scale-100"
                                            leave-to="opacity-0 scale-95">
                                            <DialogPanel
                                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                                <DialogTitle
                                                    as="h3"
                                                    class="text-xl font-bold leading-6 text-gray-900 inline-flex items-center space-x-5"
                                                >
                                                    <svg aria-hidden="true"
                                                         class="w-8" fill="currentColor"
                                                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path clip-rule="evenodd"
                                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z"
                                                              fill-rule="evenodd"></path>
                                                    </svg>
                                                    Yakin Akan Logout?
                                                </DialogTitle>
                                                <div class="mt-2">
                                                    <p class="text-md text-gray-500">
                                                        Halaman Akan Dialihkan Ke Login Form
                                                    </p>
                                                </div>

                                                <div class="mt-4">
                                                    <Link :href="route('logout')" as="button"
                                                          class="inline-flex mr-2 justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                                          method="post"
                                                    >
                                                        Logout
                                                    </Link>
                                                    <button
                                                        class="inline-flex justify-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-sm font-medium text-white hover:bg-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                                        type="button"
                                                        @click="closeModal">
                                                        Close
                                                    </button>
                                                </div>
                                            </DialogPanel>
                                        </TransitionChild>
                                    </div>
                                </div>
                            </Dialog>
                        </TransitionRoot>
                    </div>
                </div>
                <div
                    class="absolute bottom-0 left-0 justify-center hidden w-full p-4 space-x-4 bg-white lg:flex dark:bg-gray-800"
                    sidebar-bottom-menu="">
                    <a class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white"
                       href="#">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"></path>
                        </svg>
                    </a>
                    <a class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white"
                       data-tooltip-target="tooltip-settings"
                       href="https://flowbite-admin-dashboard.vercel.app/settings/">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                  fill-rule="evenodd"></path>
                        </svg>
                    </a>
                    <div id="tooltip-settings"
                         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                         data-popper-placement="top"
                         role="tooltip"
                         style="position: absolute; inset: auto auto 0 0; margin: 0; transform: translate(71px, -64px);">
                        Settings page
                        <div class="tooltip-arrow" data-popper-arrow=""
                             style="position: absolute; left: 0; transform: translate(55px, 0px);"></div>
                    </div>
                    <button
                        class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white"
                        data-dropdown-toggle="language-dropdown"
                        type="button">
                        <svg class="h-5 w-5 rounded-full mt-0.5" viewBox="0 0 3900 3900"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M0 0h7410v3900H0z" fill="#b22234"></path>
                            <path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff"
                                  stroke-width="300"></path>
                            <path d="M0 0h2964v2100H0z" fill="#3c3b6e"></path>
                            <g fill="#fff">
                                <g id="d">
                                    <g id="c">
                                        <g id="e">
                                            <g id="b">
                                                <path id="a"
                                                      d="M247 90l70.534 217.082-184.66-134.164h228.253L176.466 307.082z"></path>
                                                <use xlink:href="#a" y="420"></use>
                                                <use xlink:href="#a" y="840"></use>
                                                <use xlink:href="#a" y="1260"></use>
                                            </g>
                                            <use xlink:href="#a" y="1680"></use>
                                        </g>
                                        <use x="247" xlink:href="#b" y="210"></use>
                                    </g>
                                    <use x="494" xlink:href="#c"></use>
                                </g>
                                <use x="988" xlink:href="#d"></use>
                                <use x="1976" xlink:href="#c"></use>
                                <use x="2470" xlink:href="#e"></use>
                            </g>
                        </svg>
                    </button>

                    <div
                        id="language-dropdown"
                        class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700"
                        data-popper-placement="bottom"
                        style="position: absolute; inset: 0 auto auto 0; margin: 0; transform: translate(184px, 977px);">
                        <ul class="py-1" role="none">
                            <li>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                   href="#"
                                   role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg id="flag-icon-css-us" class="h-3.5 w-3.5 rounded-full mr-2"
                                             viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                            <g fill-rule="evenodd">
                                                <g stroke-width="1pt">
                                                    <path
                                                        d="M0 0h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                                        fill="#bd3d44"
                                                        transform="scale(3.9385)"></path>
                                                    <path
                                                        d="M0 10h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                                        fill="#fff"
                                                        transform="scale(3.9385)"></path>
                                                </g>
                                                <path d="M0 0h98.8v70H0z" fill="#192f5d"
                                                      transform="scale(3.9385)"></path>
                                                <path
                                                    d="M8.2 3l1 2.8H12L9.7 7.5l.9 2.7-2.4-1.7L6 10.2l.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7L74 8.5l-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 7.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 24.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 21.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 38.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 35.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 52.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 49.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 66.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 63.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9z"
                                                    fill="#fff"
                                                    transform="scale(3.9385)"></path>
                                            </g>
                                        </svg>
                                        English (US)
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                   href="#"
                                   role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg id="flag-icon-css-de" class="h-3.5 w-3.5 rounded-full mr-2"
                                             viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 341.3h512V512H0z" fill="#ffce00"></path>
                                            <path d="M0 0h512v170.7H0z"></path>
                                            <path d="M0 170.7h512v170.6H0z" fill="#d00"></path>
                                        </svg>
                                        Deutsch
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                   href="#"
                                   role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg id="flag-icon-css-it" class="h-3.5 w-3.5 rounded-full mr-2"
                                             viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                            <g fill-rule="evenodd" stroke-width="1pt">
                                                <path d="M0 0h512v512H0z" fill="#fff"></path>
                                                <path d="M0 0h170.7v512H0z" fill="#009246"></path>
                                                <path d="M341.3 0H512v512H341.3z" fill="#ce2b37"></path>
                                            </g>
                                        </svg>
                                        Italiano
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                   href="#"
                                   role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg id="flag-icon-css-cn" class="h-3.5 w-3.5 rounded-full mr-2"
                                             viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <defs>
                                                <path id="a" d="M1-.3L-.7.8 0-1 .6.8-1-.3z" fill="#ffde00"></path>
                                            </defs>
                                            <path d="M0 0h512v512H0z" fill="#de2910"></path>
                                            <use height="20" transform="matrix(76.8 0 0 76.8 128 128)" width="30"
                                                 xlink:href="#a"></use>
                                            <use height="20" transform="rotate(-121 142.6 -47) scale(25.5827)"
                                                 width="30"
                                                 xlink:href="#a"></use>
                                            <use height="20" transform="rotate(-98.1 198 -82) scale(25.6)" width="30"
                                                 xlink:href="#a"></use>
                                            <use height="20" transform="rotate(-74 272.4 -114) scale(25.6137)"
                                                 width="30"
                                                 xlink:href="#a"></use>
                                            <use height="20" transform="matrix(16 -19.968 19.968 16 256 230.4)"
                                                 width="30"
                                                 xlink:href="#a"></use>
                                        </svg>
                                        中文 (繁體)
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</template>
