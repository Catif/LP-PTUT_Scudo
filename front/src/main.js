// Library Vue
import { createApp } from "vue";
import router from "./router/index.js";

// Library
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
import "@/assets/fonts/icon.css";

// Propriété Application
app.use(pinia).use(router);
app.mount("#app");
