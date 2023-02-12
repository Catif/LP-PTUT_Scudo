import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "Home",
      component: () => import("@/views/ExampleView.vue"),
    },
    {
      path: "/test",
      name: "test",
      component: () => import("@/views/TestView.vue"),
    },
  ],
});

export default router;
