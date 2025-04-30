<script setup>
import { ref, watch, defineEmits, defineProps } from "vue";
import axios from "../axios";

const props = defineProps({
    show: Boolean,
    isUpdateMode: Boolean,
    editingUserId: Number,
});

const emit = defineEmits(["close", "refresh"]);

const form = ref({
    name: "",
    email: "",
    password: "",
});

const selectedRole = ref(null);

const roles = [
    { id: 1, name: "admin" },
    { id: 2, name: "librarian" },
    { id: 3, name: "user" },
];
watch(
    () => props.isUpdateMode,
    (isUpdate) => {
        form.value = isUpdate
            ? { password: "" }
            : { name: "", email: "", password: "" };
        selectedRole.value = null;
    },
    { immediate: true }
);

const handleSubmit = async () => {
    try {
        const roleId = selectedRole.value;
        if (!roleId) {
            console.error("Роль не выбрана");
            return;
        }
        if (props.isUpdateMode) {
            await axios.put(`/users/${props.editingUserId}/password`, {
                user_id: props.editingUserId,
                password: form.value.password,
            });
        } else {
            await axios.post("/users", {
                name: form.value.name,
                email: form.value.email,
                password: form.value.password,
                role_id: roleId,
            });
        }
        emit("refresh");
        emit("close");
    } catch (err) {
        console.error("Ошибка:", err);
    }
};
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">
                {{ isUpdateMode ? "Изменить пароль" : "Добавить пользователя" }}
            </h2>
            <form @submit.prevent="handleSubmit">
                <div class="mb-4" v-if="!isUpdateMode">
                    <label class="block mb-1">Имя:</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>
                <div class="mb-4" v-if="!isUpdateMode">
                    <label class="block mb-1">Email:</label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Пароль:</label>
                    <input
                        v-model="form.password"
                        type="new-password"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>
                <div class="mb-4" v-if="!isUpdateMode">
                    <label class="block mb-1">Роль:</label>
                    <select
                        v-model="selectedRole"
                        class="w-full border rounded p-2"
                        required
                    >
                        <option
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                        >
                            {{ role.name }}
                        </option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button
                        @click="emit('close')"
                        type="button"
                        class="px-4 py-2 bg-gray-300 rounded"
                    >
                        Отмена
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded"
                    >
                        {{ isUpdateMode ? "Обновить" : "Добавить" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
