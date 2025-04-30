<script setup>
import { ref, onMounted } from "vue";
import axios from "../axios";

const books = ref([]);

const getBooks = async () => {
    try {
        const response = await axios.get("/book");
        books.value = response.data;
    } catch (err) {
        console.error("Ошибка при загрузке книг:", err);
    }
};

const deleteBook = async (bookId) => {
    try {
        await axios.delete(`/books/${bookId}`);
        await getBooks();
    } catch (err) {
        console.error("Ошибка при удалении книги:", err);
    }
};

onMounted(() => {
    getBooks();
});
</script>

<template>
    <div class="container mx-auto mt-10 p-6 bg-white rounded shadow-md">
        <h1 class="text-2xl font-bold mb-6">Список книг</h1>
        <div class="grid grid-cols-5 font-semibold border-b pb-2 mb-4">
            <div>ID</div>
            <div>Название</div>
            <div>Автор</div>
            <div>Резерв</div>
            <div>Удалить</div>
        </div>
        <div
            v-for="book in books"
            :key="book.id"
            class="grid grid-cols-5 items-center border-b py-2"
        >
            <div>{{ book.id }}</div>
            <div>{{ book.title }}</div>
            <div>{{ book.author }}</div>
            <div>{{ book.is_reserved ? "Да" : "Нет" }}</div>
            <div>
                <button
                    @click="deleteBook(book.id)"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                >
                    Удалить
                </button>
            </div>
        </div>
    </div>
</template>
