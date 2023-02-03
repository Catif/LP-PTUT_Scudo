// Library Vue
import { createApp } from "vue";
import router from "./router/index.js";

// Library
import axios from "axios";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

// Importation Fichier Vue
import App from "./App.vue";

// Déclaration
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
const app = createApp(App);

// Fichier CSS
import "@/assets/css/main.css";

// Propriété Application
app.use(pinia).use(router);
app.mount("#app");

// Variable Globale pour Axios nommé "api"
window.API = axios.create({
  baseURL: "https://localhost:8000/", //! URL de l'API
  defaults: {
    headers: {
      common: {
        "X-Requested-With": "XMLHttpRequest",
      },
    },
  },
});
