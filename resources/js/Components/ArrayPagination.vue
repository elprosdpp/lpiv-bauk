<template>
    <nav aria-label="Page navigation example" class="flex justify-end">
        <ul class="flex items-center mt-4 space-x-4">
            <!-- Button -->
            <li class="">
                <button
                    type="button"
                    @click="onClickPreviousPage"
                    :disabled="isInFirstPage"
                    class="flex items-center text-xs text-gray-900 dark:text-white"
                >
                    &laquo; Previous
                </button>
            </li>
            <!-- End Button -->

            <!-- Index Halaman Sesuai Total Page -->
            <li v-for="page in pages" :key="page.name" class="">
                <button
                    type="button"
                    @click="onClickPage(page.name)"
                    :disabled="page.isDisabled"
                    :class="{ activePage: isPageActive(page.name) }"
                    class="flex items-center text-xs text-gray-900 dark:text-white"
                >
                    {{ page.name }}
                </button>
            </li>
            <!-- End Index Halaman Sesuai Total Page -->

            <!-- Button -->
            <li>
                <button
                    type="button"
                    @click="onClickNextPage"
                    :disabled="isInLastPage"
                    class="flex items-center text-xs text-gray-900 dark:text-white"
                > Next &raquo;
                </button>
            </li>
        </ul>
    </nav>
</template>

<script setup>

import {computed, watchEffect} from "vue";

const emit = defineEmits(["pagechanged"]);
const props = defineProps({
    maxVisibleButtons: {
        type: Number,
        required: false,
        default: 3,
    },
    totalPages: {
        value: [Number, String],
        required: false,
    },
    perPage: {
        value: [Number, String],
        required: false,
        default: 5
    },
    currentPage: {
        type: Number,
        required: false,
        default: 1,
    },
});

const startPage = computed(() => {
    // When on the first page
    if (props.currentPage === 1) {
        return 1;
    }

    // When on the last page
    if (props.currentPage === props.totalPages) {
        const start = props.totalPages - (props.maxVisibleButtons - 1);

        if (start === 0) {
            return 1;
        } else {
            return start;
        }
    }

    // When inbetween
    return props.currentPage - 1;
});

const pages = computed(() => {
    const range = [];

    for (
        let i = startPage.value;
        i <= Math.min(startPage.value + props.maxVisibleButtons - 1, props.totalPages);
        i++
    ) {
        range.push({
            name: i,
            isDisabled: i === props.currentPage,
        });
    }

    return range;
});

const isInFirstPage = computed(() => {
    return props.currentPage === 1;
});

const isInLastPage = computed(() => {
    return props.currentPage === props.totalPages;
});

const onClickFirstPage = () => {
    emit("pagechanged", 1);
};

const onClickPreviousPage = () => {
    emit("pagechanged", props.currentPage - 1);
};

const onClickPage = (page) => {
    emit("pagechanged", page);
};

const onClickNextPage = () => {
    emit("pagechanged", props.currentPage + 1);
};

const onClickLastPage = () => {
    emit("pagechanged", props.totalPages);
};

const isPageActive = (page) => {
    return props.currentPage === page;
};

</script>

