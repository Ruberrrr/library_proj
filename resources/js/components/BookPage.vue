<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "../axios";
import { inject } from "vue";
import { useRouter } from "vue-router";
const books = ref([]);
const sortBy = ref("");
const search = ref("");
const router = useRouter();
const isAuthenticated = ref(true);

const loadBooks = async () => {
    try {
        const response = await axios.get("/book", {
            params: {
                sortBy: sortBy.value,
                search: search.value,
            },
        });
        books.value = response.data;
    } catch (error) {
        console.error("Ошибка при загрузке книг:", error);
        alert("Не удалось загрузить книги");
    }
};
onMounted(() => {
    const token = localStorage.getItem("token");
    isAuthenticated.value = !!token;

    loadBooks();
});
const logout = async () => {
    try {
        await axios.post("/logout", {});

        localStorage.removeItem("token");
        localStorage.removeItem("role");

        axios.defaults.headers.common["Authorization"] = null;
        isAuthenticated.value = false;
    } catch (error) {
        console.error("Ошибка выхода:", error);
    }
};
watch([sortBy, search], () => {
    loadBooks();
});

const onChangeSelect = (event) => {
    sortBy.value = event.target.value;
};
const { openAuth } = inject("AuthActions");
</script>

<template>
    <div class="container mx-auto mt-8 p-4 bg-white rounded-md">
        <div
            class="flex w-full justify-between items-center px-2 sticky top-0 shadow-md rounded-md bg-white mb-8 z-10"
        >
            <h1 class="text-3xl text-black font-semibold mb-6">Библиотека</h1>
            <div class="flex gap-4">
                <select
                    @change="onChangeSelect"
                    class="py-2 px-3 border rounded-md outlane-none"
                >
                    <option value="author">По автору</option>
                    <option value="alpabet">По алфавиту</option>
                </select>
            </div>
            <div class="flex justify-between relative">
                <img
                    src="../assets/svg/search.svg"
                    alt="search"
                    class="absolute w-6 h-6 top-2.5 left-3"
                />
                <input
                    v-model="search"
                    type="text"
                    placeholder="Поиск..."
                    class="mr-5 pl-10 pr-4 border rounded-md outline-none"
                />
                <button
                    v-if="isAuthenticated"
                    @click="logout"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                >
                    Выход
                </button>
                <button
                    v-else
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    @click="openAuth"
                >
                    Вход
                </button>
            </div>
        </div>
        <h2 class="text-lg text-gray-400 font-normal ml-2 mb-6">
            Список книг:
        </h2>
        <div
            class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-8"
        >
            <div
                v-for="book in books"
                :key="book.id"
                class="relative bg-white p-4 rounded-xl shadow-lg"
            >
                <img
                    class="w-14 h-14 absolute top-3 left-3 cursor-pointer hover:scale-105 transition"
                    src="../assets/svg/favorite.svg"
                    alt="favorite"
                />
                <img src="../assets/images/book.jpg" alt="Book" />
                <h2 class="text-xl font-semibold my-2">
                    {{ book.title }}
                </h2>
                <p class="text-gray-500 mb-4">{{ book.author }}</p>
            </div>
        </div>
    </div>
</template>
