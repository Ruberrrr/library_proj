<script setup>
import { onMounted, ref } from "vue";
import axios from "../axios";
import BookForm from "./BookForm.vue";

const books = ref([]);
const modalOpen = ref(false);
const isBookAdd = ref(false);
const isGive = ref(false);
const getBook = async () => {
    try {
        const response = await axios.get("/book");
        books.value = response.data;
    } catch (err) {
        err.value = "Ошибка при загрузке книг";
    }
};
const toggleGive = async (bookId) => {
    try {
        await axios.patch(`/book/${bookId}/toggle-give`);
        await getBook();
    } catch (err) {
        console.error("Ошибка при изменении статуса книги", err);
    }
};
const openAddBook = () => {
    modalOpen.value = true;
};
const closeModal = () => {
    modalOpen.value = false;
};
const bookDelete = async (bookId) => {
    try {
        await axios.delete(`/book/${bookId}`);
        await getBook();
    } catch (err) {
        console.error("Ошибка при удалении пользователя:", err);
    }
};
onMounted(() => {
    getBook();
});
</script>
<template>
    <BookForm
        :show="modalOpen"
        :isBookAdd="isBookAdd"
        @close="closeModal"
        @refresh="getBook"
    />
    <div class="container mx-auto mt-10 p-4 bg-white rounded-md">
        <header class="flex justify-between items-center">
            <h1 class="text-2xl text-black font-semibold mb-6">
                Управление книгами
            </h1>
            <div class="flex justify-end">
                <router-link
                    to="/"
                    class="bg-blue-200 rounded-xl mr-5 px-3 py-1"
                >
                    Главная
                </router-link>
                <button
                    @click="openAddBook"
                    class="bg-blue-200 rounded-xl px-3 py-1"
                >
                    Добавить книгу
                </button>
            </div>
        </header>
        <h2 class="text-xl text-black font-medium mb-4">Список книг:</h2>
        <div class="grid grid-cols-4 mb-4">
            <p>id:</p>
            <p class="">Название и автор книги:</p>
            <p class="mx-auto">Удалить книгу:</p>
            <p class="mx-auto">Выдача/принятие</p>
        </div>
        <div
            v-for="book in books"
            :key="book.id"
            class="grid grid-cols-4 row mb-4"
        >
            <p class="font-bold">{{ book.id }}</p>
            <p class="">{{ book.title }}, {{ book.author }}</p>
            <svg
                class="cursor-pointer mx-auto"
                @click="bookDelete(book.id)"
                fill="#f73636"
                width="30px"
                height="30px"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                stroke="#f73636"
            >
                <path
                    d="M1,20a1,1,0,0,0,1,1h8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5Zm12.707,9.707L20.414,17l2.293,2.293a1,1,0,1,1-1.414,1.414L19,18.414l-2.293,2.293a1,1,0,0,1-1.414-1.414L17.586,17l-2.293-2.293a1,1,0,0,1,1.414-1.414L19,15.586l2.293-2.293a1,1,0,0,1,1.414,1.414Z"
                />
            </svg>
            <button
                @click="toggleGive(book.id)"
                class="mx-auto bg-blue-200 rounded-xl px-3 py-1"
            >
                {{ book.give ? "Принята" : "Выдана" }}
            </button>
        </div>
    </div>
</template>
