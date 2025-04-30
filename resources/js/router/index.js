import { createRouter, createWebHistory } from "vue-router";
import BookForm from "../components/BookForm.vue";
import BookPage from "../components/BookPage.vue";
import AdminPanel from "../components/Admin.vue";

const routes = [
    {
        path: "/",
        name: "books",
        component: BookPage,
    },
    {
        path: "/books/create",
        name: "BookCreate",
        component: BookForm,
        meta: { requiresAuth: true, requiresRole: "librarian" },
    },
    {
        path: "/admin",
        name: "AdminPanel",
        component: AdminPanel,
        meta: { requiresAuth: true, requiresRole: "admin" },
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
