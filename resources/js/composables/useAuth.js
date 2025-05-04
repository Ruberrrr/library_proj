import { ref } from "vue";
import axios from "../axios";
import { useRouter } from "vue-router";

const userRole = ref("guest");
const userId = ref(null);

export const useAuth = () => {
    const router = useRouter();

    const checkAuth = () => {
        const storedRole = localStorage.getItem("role");
        const token = localStorage.getItem("token");
        if (token && storedRole) {
            userRole.value = storedRole || "guest";
            userId.value = Number(localStorage.getItem("userId"));
        } else {
            userRole.value = "guest";
            userId.value = null;
        }
    };

    const logout = async () => {
        try {
            await axios.post("/logout", {});
            localStorage.removeItem("token");
            localStorage.removeItem("role");
            localStorage.removeItem("userId");

            userRole.value = "guest";
            userId.value = null;

            router.push("/");
        } catch (error) {
            console.error("Ошибка выхода:", error);
        }
    };

    return {
        userRole,
        userId,
        checkAuth,
        logout,
    };
};
