<script setup>
import { onMounted, watch, inject } from "vue";
import axios from "../axios";
import BookPageHeader from "../components/BookPageHeader.vue";
import BookCard from "../components/BookCard.vue";
import SkeletonCard from "../components/SkeletonCard.vue";
import { useSkeleton } from "../composables/Skeleton";
import { useAuth } from "../composables/useAuth";
import { useBooks } from "../composables/useBooks";

const { userRole, userId, checkAuth, logout } = useAuth();
const { books, loading, sortBy, search, loadBooks } = useBooks();
const { openAuth } = inject("AuthActions");

const reserveBook = async (book) => {
    if (book.is_reserved) {
        alert("Эта книга уже зарезервирована!");
        return;
    }
    try {
        await axios.post(`/book/${book.id}/reserve`, {
            user_id: userId,
        });
        book.is_reserved = true;
        alert("Книга успешно забронирована!");
    } catch (error) {
        alert(
            error.response?.data?.message || "Ошибка при резервировании книги."
        );
    }
};
const { skeletons, realBooks } = useSkeleton(loading, books);
onMounted(async () => {
    checkAuth();
    loadBooks(userRole.value, userId.value);
});

watch([sortBy, search], () => {
    loadBooks(userRole.value, userId.value);
});
</script>
<template>
    <div class="container mx-auto mt-8 p-4 bg-white rounded-md">
        <BookPageHeader
            :search="search"
            :userRole="userRole"
            @update:search="search = $event"
            @sort-change="(val) => (sortBy = val)"
            @logout="logout"
            @open-auth="openAuth"
        />
        <h2 class="text-lg text-gray-400 font-normal ml-2 mb-6">
            Список книг:
        </h2>
        <div
            class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8"
        >
            <SkeletonCard v-for="s in skeletons" :key="s.id" />
            <BookCard
                v-for="b in realBooks"
                :key="b.id"
                :book="b"
                :userRole="userRole"
                :openAuth="openAuth"
                :reserveBook="reserveBook"
            />
        </div>
    </div>
</template>
