<script setup>
import { ref } from "vue";
import axios from "../axios";
import { useRouter } from "vue-router";
import AuthHeader from "./AuthHeader.vue";
import { inject } from "vue";

const email = ref("");
const password = ref("");
const router = useRouter();
const authOpen = ref(true);

const { closeAuth } = inject("AuthActions");

const login = async () => {
    try {
        const response = await axios.post("/login", {
            email: email.value,
            password: password.value,
        });

        const token = response.data.token;
        const roles = response.data.role;
        const id = response.data.id;

        if (token) {
            localStorage.setItem("token", token);
            localStorage.setItem("role", roles[0]);
            localStorage.setItem("userId", response.data.id);
        } else {
        }
        authOpen.value = false;
        const userRole = localStorage.getItem("role");

        if (roles.includes("admin")) {
            router.push("/admin");
        } else if (roles.includes("librarian")) {
            router.push("/librarian");
        } else {
            router.push("/");
        }
        closeAuth();
    } catch (error) {}
};
</script>

<template>
    <div
        class="fixed left-0 top-0 bg-black opacity-50 z-20 w-full h-full"
    ></div>
    <div
        class="fixed inset-0 flex items-center justify-center z-20 w-full h-full"
    >
        <div class="basis-1/3 mx-auto p-4 bg-zinc-200 shadow rounded">
            <AuthHeader />
            <form @submit.prevent="login">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium"
                        >Логин:</label
                    >
                    <input
                        type="email"
                        v-model="email"
                        id="email"
                        required
                        autocomplete="email"
                        class="mt-1 block w-full border border-gray-300 rounded p-2"
                    />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium"
                        >Пароль:</label
                    >
                    <input
                        type="password"
                        v-model="password"
                        id="password"
                        required
                        autocomplete="current-password"
                        class="mt-1 block w-full border border-gray-300 rounded p-2"
                    />
                </div>
                <button
                    type="submit"
                    class="bg-blue-600 text-white mr-8 px-4 py-2 rounded hover:bg-blue-700"
                >
                    Войти
                </button>
                <router-link
                    @click="closeAuth()"
                    to="/forgot-password"
                    class="bg-blue-600 text-white mr-8 px-4 py-2 rounded hover:bg-blue-700"
                    >Восстановление пароля</router-link
                >
            </form>
        </div>
    </div>
</template>
