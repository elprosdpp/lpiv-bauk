<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>


<template>
    <div v-if="data.links?.length > 3" class="flex justify-end mt-4 space-x-4">
        <Link
            v-for="(link, k) in data?.links"
            :key="k"
            :class="{'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs w-full sm:w-auto px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800': link.active}"
            :href="link?.url ? link.url : ''"
            class="flex items-center text-xs text-gray-900 dark:text-white"
            v-html="link?.label"
        />
    </div>
</template>
