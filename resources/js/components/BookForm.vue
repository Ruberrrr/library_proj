<script setup>
import { ref, defineEmits, defineProps } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const form = ref({
    title: "",
    author: "",
});
const props = defineProps({
    show: Boolean,
    isBookAdd: Boolean,
});
const emit = defineEmits(["close", "refresh"]);
const message = ref("");
const error = ref("");
const router = useRouter();

const submitBook = async () => {
    if (!form.title || !form.author) {
        error.value = "Заполните все поля!";
        message.value = "";
        return;
    }
    try {
        const response = await axios.post("/book", form);
        message.value = `Книга добавлена: ${response.data.title}`;
        error.value = "";

        form.title = "";
        form.author = "";
        emit("refresh");
        emit("close");
    } catch (err) {
        error.value =
            err.response?.data?.message || "Ошибка при добавлении книги";
    }
};
function goToBooks() {
    router.push({ name: "books" });
}
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="basis-1/3 mx-auto p-4 bg-zinc-200 shadow rounded">
            <h2 class="text-xl font-bold mb-4">Добавить книгу</h2>
            <form @submit.prevent="submitBook">
                <div class="mb-4">
                    <label class="block text-sm font-medium">Название:</label>
                    <input
                        type="text"
                        v-model="form.title"
                        class="mt-1 block w-full border border-gray-300 rounded p-2"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Автор:</label>
                    <input
                        type="text"
                        v-model="form.author"
                        class="mt-1 block w-full border border-gray-300 rounded p-2"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="bg-blue-600 text-white mr-8 px-4 py-2 rounded hover:bg-blue-700"
                >
                    Сохранить
                </button>
                <button
                    type="button"
                    @click="emit('close')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Назад
                </button>
            </form>

            <div v-if="message" class="mt-4 text-green-600">{{ message }}</div>
            <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
        </div>
    </div>
</template>
