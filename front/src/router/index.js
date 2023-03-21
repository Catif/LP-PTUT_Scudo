import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("@/views/TestView.vue"),
    },
    {
      path: "/settings",
      name: "settings",
      component: () => import("@/views/ExampleView.vue"),
    },
    {
      path: "/register",
      name: "register",
      component: () => import("@/views/RegisterView.vue"),
    },
    {
      path: "/record/:accessibility",
      name: "record",
      component: () => import("@/views/RecordView.vue"),
    },
    {
      path: "/resource/edit/:id",
      name: "resource",
      component: () => import("@/views/EditResourceView.vue"),
    },
    {
      path: "/resource/:id",
      name: "resource",
      component: () => import("@/views/ResourceView.vue"),
    },
    {
      path: "/login",
      name: "login",
      component: () => import("@/views/LoginView.vue"),
    },
  ],
});

export default router;
