// Library Vue
import { createApp } from "vue";
import router from "./router/index.js";


// Library
import axios from "axios";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'


// Importation Fichier Vue
import App from "./App.vue";


// Déclaration
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate)
const app = createApp(App);


// Propriété Application
app.use(pinia).use(router);
app.mount("#app");


// Variable Globale pour Axios
window.api = axios.create({
  baseURL: "https://localhost:8000/api/", //! Url API temporaire le temps de voir comment fonctionne l'API Laravel
  defaults: {
    headers: {
      common: {
        "X-Requested-With": "XMLHttpRequest",
      },
    },
  },
});