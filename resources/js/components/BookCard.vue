<script setup>
const props = defineProps({
    book: Object,
    userRole: String,
    openAuth: Function,
    reserveBook: Function,
});
const handleReserve = () => {
    props.reserveBook(props.book);
};
const getIconPath = (isReserved) => {
    return new URL(
        `../assets/svg/${isReserved ? "favorite-fill" : "favorite"}.svg`,
        import.meta.url
    ).href;
};
</script>
<template>
    <div class="relative bg-white p-4 rounded-xl shadow-lg">
        <img
            v-if="userRole !== 'guest'"
            @click="handleReserve"
            class="w-14 h-14 absolute top-3 left-3 cursor-pointer hover:scale-105 transition"
            :src="getIconPath(book.is_reserved)"
            alt="favorite"
        />
        <img
            v-else
            @click="openAuth"
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
</template>
