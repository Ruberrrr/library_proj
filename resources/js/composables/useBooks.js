import { ref } from "vue";
import axios from "../axios";

export const useBooks = () => {
    const books = ref([]);
    const loading = ref(true);
    const sortBy = ref("");
    const search = ref("");

    const loadBooks = async (userRole, userId) => {
        try {
            const response = await axios.get("/book", {
                withCredentials: true,
                params: {
                    sortBy: sortBy.value,
                    search: search.value,
                },
            });

            if (userRole === "user") {
                books.value = response.data.filter(
                    (book) => !book.reserved_by || book.reserved_by === userId
                );
            } else {
                books.value = response.data;
            }
            loading.value = false;
        } catch (error) {
            console.error("Ошибка при загрузке книг:", error);
            alert("Не удалось загрузить книги");
            loading.value = false;
        }
    };

    return {
        books,
        loading,
        sortBy,
        search,
        loadBooks,
    };
};
