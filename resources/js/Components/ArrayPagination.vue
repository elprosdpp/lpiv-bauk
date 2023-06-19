<template>
    <nav aria-label="Page navigation example">
        <ul class="inline-flex -space-x-px">
            <!-- Button -->
            <li>
                <button
                    type="button"
                    @click="onClickFirstPage"
                    :disabled="isInFirstPage"
                    class="p-2 mx-1 leading-tight text-gray-500 bg-white rounded-full border border-gray-300 hover:bg-gray-100"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M15.79 14.77a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L11.832 10l3.938 3.71a.75.75 0 01.02 1.06zm-6 0a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L5.832 10l3.938 3.71a.75.75 0 01.02 1.06z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </li>
            <li>
                <button
                    type="button"
                    @click="onClickPreviousPage"
                    :disabled="isInFirstPage"
                    class="p-2 mx-1 leading-tight rounded-full text-gray-500 bg-white border border-gray-300 hover:bg-gray-100"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </li>
            <!-- End Button -->

            <!-- Index Halaman Sesuai Total Page -->
            <li v-for="page in pages" :key="page.name">
                <button
                    type="button"
                    @click="onClickPage(page.name)"
                    :disabled="page.isDisabled"
                    :class="{ activePage: isPageActive(page.name) }"
                    class="py-3 px-4 mx-1 text-xs leading-3 rounded-full text-gray-500 bg-white border border-gray-300 hover:bg-gray-100"
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
                    class="p-2 mx-1 leading-tight rounded-full text-gray-500 bg-white border border-gray-300 hover:bg-gray-100"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </li>
            <li>
                <button
                    type="button"
                    @click="onClickLastPage"
                    :disabled="isInLastPage"
                    class="p-2 mx-1 leading-tight rounded-full text-gray-500 bg-white border border-gray-300 hover:bg-gray-100"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.21 14.77a.75.75 0 01.02-1.06L14.168 10 10.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                            clip-rule="evenodd"
                        />
                        <path
                            fill-rule="evenodd"
                            d="M4.21 14.77a.75.75 0 01.02-1.06L8.168 10 4.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </li>
            <!-- End Button -->
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

watchEffect(() => {
    console.log(props.currentPage)
});
</script>

<style scoped>
.activePage {
    background-color: blue;
    color: white;
}
</style>
