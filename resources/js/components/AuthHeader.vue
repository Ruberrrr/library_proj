<script setup>
import { inject } from "vue";

const { closeAuth } = inject("AuthActions");
</script>

<template>
    <div class="flex items-center mb-4 justify-between">
        <h2 class="text-xl font-bold">Авторизация</h2>
        <svg
            @click="closeAuth"
            class="opacity-80 cursor-pointer hover:opacity-100"
            width="16"
            height="16"
            viewBox="0 0 16 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M1 7H14.7143"
                stroke="#426AB2"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M8.71436 1L14.7144 7L8.71436 13"
                stroke="#426AB2"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </div>
</template>
