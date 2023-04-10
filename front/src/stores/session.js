import { defineStore } from "pinia";
import { reactive } from "vue";
import { useRouter } from "vue-router";

export const useSessionStore = defineStore(
  "session",
  () => {
    const router = useRouter();
    const data = reactive({
      token: "",
      id: "",
    });

    function setSession(t, id) {
      data.token = t;
      data.id = id;
    }

    function emptySession() {
      data.token = "";
      router.push("/login");
    }

    return { data, setSession, emptySession };
  },
  {
    persist: true,
  }
);
