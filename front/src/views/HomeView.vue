<script setup>
// Importation de la méthode Ref de Vue.js
import { ref } from "vue";

// Déclaration de la variable user en réactive
const user = ref({});

// Appel à une API de test
// ps: API est déclaré dans le main.js
// remarque: le lien défini dans la variable API, peut être écrasé par un autre lien
API.get("https://jsonplaceholder.typicode.com/users/1")
  .then((response) => {
    // Récupération des informations
    user.value = response.data;
  })
  .catch((error) => {
    console.log(error);
  });
</script>

<template>
  <div>
    <h1>Bonjour monde!</h1>
    <p>Je suis un composant Vue.js nommé <b>Home</b></p>

    <h2>Exemple de code pour axios</h2>
    <pre>
      <code>
        <!-- Implémentation dans le HTML -->
{{ user }}
      </code>
    </pre>
  </div>
</template>
