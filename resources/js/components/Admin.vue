<script setup>
import { onMounted, ref } from "vue";
import axios from "../axios";
import AdminForm from "../components/AdminForm.vue";

const users = ref([]);
const modalOpen = ref(false);
const isUpdateMode = ref(false);
const editingUserId = ref(null);

const getUsers = async () => {
    try {
        const response = await axios.get("/users");
        users.value = response.data;
    } catch (err) {
        err.value = "Ошибка при загрузке пользователей";
    }
};
const openAddUser = () => {
    isUpdateMode.value = false;
    editingUserId.value = null;
    modalOpen.value = true;
};
const openUpdatePassword = (userId) => {
    isUpdateMode.value = true;
    editingUserId.value = userId;
    modalOpen.value = true;
};
const userDelete = async (userId) => {
    try {
        await axios.delete(`/users/${userId}`);
        await getUsers();
    } catch (err) {
        console.error("Ошибка при удалении пользователя:", err);
    }
};
const closeModal = () => {
    modalOpen.value = false;
};
onMounted(() => {
    getUsers();
});
</script>

<template>
    <AdminForm
        :show="modalOpen"
        :isUpdateMode="isUpdateMode"
        :editingUserId="editingUserId"
        @close="closeModal"
        @refresh="getUsers"
    />
    <div class="container mx-auto mt-10 p-4 bg-white rounded-md">
        <header class="flex justify-between items-center">
            <h1 class="text-2xl text-black font-semibold mb-6">
                Управление пользователями
            </h1>
            <div class="flex justify-end">
                <button class="bg-blue-200 rounded-xl mr-5 px-3 py-1">
                    <a href="/">Главная</a>
                </button>
                <button
                    @click="openAddUser"
                    class="bg-blue-200 rounded-xl px-3 py-1"
                >
                    Добавить пользователей
                </button>
            </div>
        </header>
        <h2 class="text-xl text-black font-medium mb-4">
            Список пользователей:
        </h2>
        <div class="grid grid-cols-5 mb-4">
            <p>id:</p>
            <p class="mx-auto">Имя пользователя:</p>
            <p class="mx-auto">Роль:</p>
            <p class="mx-auto">Почта пользователя:</p>
            <p class="mx-auto">Удалить/обновить:</p>
        </div>
        <div
            v-for="user in users"
            :key="user.id"
            class="grid grid-cols-5 row mb-4"
        >
            <p class="font-bold">{{ user.id }}</p>
            <p class="mx-auto">{{ user.name }}</p>
            <p class="mx-auto">{{ user.roles[0]?.name }}</p>
            <p class="mx-auto">{{ user.email }}</p>
            <div class="flex justify-evenly">
                <svg
                    class="cursor-pointer"
                    @click="userDelete(user.id)"
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
                <svg
                    class="cursor-pointer"
                    @click="openUpdatePassword(user.id)"
                    fill="#426AB2"
                    width="30px"
                    height="30px"
                    viewBox="-51.2 -51.2 614.40 614.40"
                    xmlns="http://www.w3.org/2000/svg"
                    stroke="#426AB2"
                    stroke-width="3.072"
                >
                    <g id="Change_password">
                        <path
                            d="M464.4326,147.54a9.8985,9.8985,0,0,0-17.56,9.1406,214.2638,214.2638,0,0,1-38.7686,251.42c-83.8564,83.8476-220.3154,83.874-304.207-.0088a9.8957,9.8957,0,0,0-16.8926,7.0049v56.9a9.8965,9.8965,0,0,0,19.793,0v-34.55A234.9509,234.9509,0,0,0,464.4326,147.54Z"
                        />
                        <path
                            d="M103.8965,103.9022c83.8828-83.874,220.3418-83.8652,304.207-.0088a9.8906,9.8906,0,0,0,16.8926-6.9961v-56.9a9.8965,9.8965,0,0,0-19.793,0v34.55C313.0234-1.3556,176.0547,3.7509,89.9043,89.9012A233.9561,233.9561,0,0,0,47.5674,364.454a9.8985,9.8985,0,0,0,17.56-9.1406A214.2485,214.2485,0,0,1,103.8965,103.9022Z"
                        />
                        <path
                            d="M126.4009,254.5555v109.44a27.08,27.08,0,0,0,27,27H358.5991a27.077,27.077,0,0,0,27-27v-109.44a27.0777,27.0777,0,0,0-27-27H153.4009A27.0805,27.0805,0,0,0,126.4009,254.5555ZM328,288.13a21.1465,21.1465,0,1,1-21.1465,21.1464A21.1667,21.1667,0,0,1,328,288.13Zm-72,0a21.1465,21.1465,0,1,1-21.1465,21.1464A21.1667,21.1667,0,0,1,256,288.13Zm-72,0a21.1465,21.1465,0,1,1-21.1465,21.1464A21.1667,21.1667,0,0,1,184,288.13Z"
                        />
                        <path
                            d="M343.6533,207.756V171.7538a87.6533,87.6533,0,0,0-175.3066,0V207.756H188.14V171.7538a67.86,67.86,0,0,1,135.7208,0V207.756Z"
                        />
                    </g>
                </svg>
            </div>
        </div>
    </div>
</template>
