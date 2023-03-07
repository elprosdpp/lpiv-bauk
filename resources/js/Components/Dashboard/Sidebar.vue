<script setup>
import {ref} from 'vue';
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

import {Link} from '@inertiajs/vue3'

const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}

function openModal() {
    isOpen.value = true
}

</script>

<template>
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        <aside id="sidebar"
               aria-label="Sidebar"
               class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width">
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
                                <Link
                                    :href="route('dashboard')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                                    <svg
                                        class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                    </svg>
                                    <span class="ml-3" sidebar-toggle-item="">Dashboard</span>
                                </Link>
                            </li>
                            <li>
                                <Disclosure>
                                    <DisclosureButton
                                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg
                                            aria-hidden="true"
                                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20"
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
                                                <a class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 "
                                                   href="https://flowbite-admin-dashboard.vercel.app/playground/stacked/">Role</a>
                                            </li>
                                            <li>
                                                <a class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 "
                                                   href="https://flowbite-admin-dashboard.vercel.app/playground/sidebar/">Permission</a>
                                            </li>
                                            <li>
                                                <a class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 "
                                                   href="https://flowbite-admin-dashboard.vercel.app/playground/sidebar/">User</a>
                                            </li>
                                        </ul>
                                    </DisclosurePanel>
                                </Disclosure>
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
                                                    <Link :href="route('logout')"
                                                          class="inline-flex mr-2 justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                                          method="post">
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
