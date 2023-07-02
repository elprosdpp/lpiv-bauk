import {ref, computed} from 'vue';

export function usePagination(items) {
    const searchQuery = ref('');
    const currentPage = ref(1);
    const itemsPerPage = ref(10); // Jumlah item per halaman, sesuaikan dengan kebutuhan Anda

    const filteredItems = computed(() => {
        const filtered = items.filter(item => {
            return item.name.toLowerCase().includes(searchQuery.value.toLowerCase());
        });

        const startIndex = (currentPage.value - 1) * itemsPerPage.value;
        const endIndex = startIndex + itemsPerPage.value;

        return filtered.slice(startIndex, endIndex);
    });

    const totalPages = computed(() => {
        return Math.ceil(filteredItems.value.length / itemsPerPage.value);
    });

    return {
        searchQuery,
        currentPage,
        itemsPerPage,
        filteredItems,
        totalPages
    };
}

