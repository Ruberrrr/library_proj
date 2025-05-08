<script setup>
import { onMounted, ref } from "vue";
import axios from "../axios";
import BookForm from "./BookForm.vue";

const books = ref([]);
const modalOpen = ref(false);
const isBookAdd = ref(false);

const getBook = async () => {
    try {
        const response = await axios.get("/book", {
            params: { context: "books" },
        });
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
        <div class="grid grid-cols-[auto,1fr,1fr,1fr,1fr] gap-4 mb-6">
            <p>id:</p>
            <p>Название и автор книги:</p>
            <p>Информация:</p>
            <p class="mx-auto">Удалить книгу:</p>
            <p class="mx-auto">Выдача/принятие</p>
        </div>
        <div
            v-for="book in books"
            :key="book.id"
            class="grid grid-cols-[auto,1fr,1fr,1fr,1fr] gap-4 row mb-6"
        >
            <p class="font-bold">{{ book.id }}</p>
            <p class="">{{ book.title }}, {{ book.author }}</p>
            <div v-if="book.give">
                <p>
                    Книга выдана библиотекарем:
                    {{ book.reservation.librarian.name }}
                </p>
                <p>
                    Дата выдачи:
                    {{ book.reservation.issued_at }}
                </p>
                <p>
                    Окончание выдачи:
                    {{ book.reservation.expires_at }}
                </p>
            </div>
            <div v-else>
                <p>Книга еще не выдана.</p>
            </div>
            <svg
                class="cursor-pointer mx-auto"
                @click="bookDelete(book.id)"
                viewBox="0 0 24 24"
                fill="#ffffff"
                width="30px"
                height="30px"
                stroke="#f73636"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="
                        M10 12V17
                        M14 12V17
                        M4 7H20
                        M6 10V18C6 19.6569 7.3431 21 9 21H15C16.6569 21 18 19.6569 18 18V10
                        M9 5C9 3.8954 9.8954 3 11 3H13C14.1046 3 15 3.8954 15 5V7H9V5Z
                    "
                />
            </svg>
            <button
                @click="toggleGive(book.id)"
                :disabled="!book.is_reserved"
                :class="[
                    'mx-auto',
                    'bg-blue-200',
                    'max-h-10',
                    'w-24',
                    'my-auto',
                    'rounded-xl',
                    'px-3',
                    'py-1',
                    { 'opacity-50 cursor-not-allowed': !book.is_reserved },
                ]"
            >
                {{ book.give ? "Принять" : "Выдать" }}
            </button>
        </div>
    </div>
</template>
