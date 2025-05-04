import { createRouter, createWebHistory } from "vue-router";
import BookPage from "../components/BookPage.vue";
import AdminPanel from "../components/Admin.vue";
import LibrarianPage from "@/components/librarianPage.vue";
import ForgotPassword from "@/components/ForgotPassword.vue";

const routes = [
    {
        path: "/",
        name: "books",
        component: BookPage,
    },
    {
        path: "/librarian",
        name: "LibrarianPage",
        component: LibrarianPage,
        meta: { requiresAuth: true, requiresRole: "librarian" },
    },
    {
        path: "/admin",
        name: "AdminPanel",
        component: AdminPanel,
        meta: { requiresAuth: true, requiresRole: "admin" },
    },
    {
        path: "/forgot-password",
        name: "ForgotPassword",
        component: ForgotPassword,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach(async (to, from) => {
    const token = localStorage.getItem("token");
    const role = localStorage.getItem("role");
    if (
        (to.meta.requiresAuth && !token) ||
        (to.meta.requiresRole && role !== to.meta.requiresRole)
    ) {
        return { path: "/" };
    }
    return true;
});
export default router;
