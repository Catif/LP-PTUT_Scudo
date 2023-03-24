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
      path: "/login",
      name: "login",
      component: () => import("@/views/LoginView.vue"),
    },
    {
      path: "/resource",
      name: "resource",
      redirect: "",
      children: [
        {
          path: ":id",
          name: "resourceByID",
          component: () => import("@/views/ResourceView.vue"),
        },
        {
          path: ":id/edit",
          name: "resourceEdit",
          component: () => import("@/views/EditResourceView.vue"),
        },
        {
          path: ":id/share",
          name: "resourceShare",
          component: () => import("@/views/ShareResourceView.vue"),
        },
      ],
    },
  ],
});

export default router;
