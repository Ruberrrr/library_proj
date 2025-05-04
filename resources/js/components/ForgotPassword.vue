<script setup>
import { ref } from "vue";
import axios from "../axios";

const email = ref("");
const status = ref("");
const error = ref("");

const sendResetLink = async () => {
    try {
        const response = await axios.post("/forgot-password", {
            email: email.value,
        });
        status.value =
            response.data.status ||
            "Ссылка для сброса пароля отправлена на ваш email.";
        error.value = "";
    } catch (err) {
        error.value =
            "Произошла ошибка при отправке ссылки. Попробуйте еще раз.";
        status.value = "";
    }
};
</script>
<template>
    <div
        class="fixed inset-0 flex items-center justify-center z-20 w-full h-full"
    >
        <div class="basis-1/3 mx-auto p-4 bg-zinc-200 shadow rounded">
            <form @submit.prevent="sendResetLink">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">
                        Введите ваш Email:
                    </label>
                    <input
                        type="email"
                        v-model="email"
                        id="email"
                        required
                        autocomplete="email"
                        class="mt-1 block w-full border border-gray-300 rounded p-2"
                    />
                </div>
                <button
                    type="submit"
                    class="bg-blue-600 text-white mr-8 px-4 py-2 rounded hover:bg-blue-700"
                >
                    Отправить ссылку для сброса пароля
                </button>
                <router-link
                    to="/"
                    class="block mt-4 text-center text-blue-600 hover:underline"
                >
                    Назад к входу
                </router-link>
            </form>
            <div v-if="status" class="mt-4 text-center text-green-600">
                {{ status }}
            </div>
            <div v-if="error" class="mt-4 text-center text-red-600">
                {{ error }}
            </div>
        </div>
    </div>
</template>
