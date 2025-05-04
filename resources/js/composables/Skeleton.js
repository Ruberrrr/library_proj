import { computed } from "vue";

export function useSkeleton(loading, books) {
    const skeletons = computed(() => {
        if (!loading.value) return [];
        return Array.from({ length: 20 }, (_, index) => ({
            id: `skeleton-${index}`,
        }));
    });

    const realBooks = computed(() => {
        return loading.value ? [] : books.value;
    });

    return {
        skeletons,
        realBooks,
    };
}
