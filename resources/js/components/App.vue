<script setup>
import { provide, ref } from "vue";
import Auth from "./Auth.vue";

const authOpen = ref(false);
const closeAuth = () => {
    authOpen.value = false;
};
const openAuth = () => {
    authOpen.value = true;
};

provide("AuthActions", {
    closeAuth,
    openAuth,
});

defineExpose({
    authOpen,
});
</script>

<template>
    <router-view></router-view>
    <Auth v-if="authOpen" />
</template>
