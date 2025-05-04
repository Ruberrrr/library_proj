<script setup>
import { defineProps, defineEmits } from "vue";

const emit = defineEmits([
    "update:search",
    "sort-change",
    "logout",
    "open-auth",
]);
const { search, userRole } = defineProps({
    search: String,
    userRole: String,
});
const onChangeSelect = (event) => {
    emit("sort-change", event.target.value);
};
const logout = () => {
    emit("logout");
};
const openAuth = () => {
    emit("open-auth");
};
const updateSearch = (event) => {
    emit("update:search", event.target.value);
};
</script>
<template>
    <div
        class="flex w-full justify-between items-center px-2 sticky top-0 shadow-md rounded-md bg-white mb-8 z-10"
    >
        <h1 class="text-3xl text-black font-semibold mb-6">Библиотека</h1>
        <router-link
            to="/admin"
            v-if="userRole === 'admin'"
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >
            Админ
        </router-link>
        <router-link
            to="/librarian"
            v-if="userRole === 'librarian'"
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >
            Библиотекарь
        </router-link>
        <div class="flex gap-4">
            <select
                @change="onChangeSelect"
                class="py-2 px-3 border rounded-md outline-none"
            >
                <option disabled selected>Сортировать по</option>
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
                :value="search"
                @input="updateSearch($event)"
                type="text"
                placeholder="Поиск..."
                class="mr-5 pl-10 pr-4 border rounded-md outline-none"
            />
            <button
                v-if="userRole !== 'guest'"
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
</template>
