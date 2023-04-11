import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({

  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("@/views/HomeView.vue"),
    },
    {
      path: "/register",
      name: "register",
      component: () => import("@/views/RegisterView.vue"),
    },
    {
      path: "/login",
      name: "login",
      component: () => import("@/views/LoginView.vue"),
    },
    {
      path: "/record/:accessibility",
      name: "record",
      component: () => import("@/views/RecordView.vue"),
    },
    {
      path: "/resource/:id",
      name: "resourceById",
      component: () => import("@/views/ResourceView.vue"),
    },
    {
      path: "/resource/:id/edit",
      name: "editResourceById",
      component: () => import("@/views/EditResourceView.vue"),
    },
    {
      path: "/resource/:id/share",
      name: "shareResourceById",
      component: () => import("@/views/ShareResourceView.vue"),
    },
    {
      path: "/profile/:id",
      name: "profile",
      component: () => import("@/views/ProfileView.vue"),
    },
    {
      path: "/profile/:id/edit",
      name: "editProfile",
      component: () => import("@/views/EditProfileView.vue"),
    },
    {
      path: "/group",
      name: "group",
      redirect: "/group/create",
      children: [
        {
          path: "create",
          name: "groupCreate",
          component: () => import("@/views/group/GroupCreateView.vue"),
        },
        {
          path: ":id",
          name: "groupByID",
          component: () => import("@/views/group/GroupView.vue"),
        },
        {
          path: ":id/edit",
          name: "groupEdit",
          component: () => import("@/views/group/GroupEditView.vue"),
        },
      ],
    },
    {
      path: "/settings",
      name: "settings",
      component: () => import("@/views/SettingsView.vue"),
    },
    {
      path: "/example",
      name: "example",
      component: () => import("@/views/ExampleView.vue"),
    },
  ],
});

export default router;
