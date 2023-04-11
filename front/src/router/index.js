import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("@/views/HomeView.vue"),
      meta: {
        auth: true,
      },
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
      path: "/record/:accessibility/:id?",
      name: "record",
      component: () => import("@/views/RecordView.vue"),
      meta: {
        auth: true,
      },
    },
    {
      path: "/resource/:id",
      name: "resourceById",
      component: () => import("@/views/ResourceView.vue"),
      meta: {
        auth: true,
      },
    },
    {
      path: "/resource/:id/edit",
      name: "editResourceById",
      component: () => import("@/views/EditResourceView.vue"),
      meta: {
        auth: true,
      },
    },
    {
      path: "/resource/:id/share",
      name: "shareResourceById",
      component: () => import("@/views/ShareResourceView.vue"),
      meta: {
        auth: true,
      },
    },
    {
      path: "/profile/:id",
      name: "profile",
      component: () => import("@/views/ProfileView.vue"),
      meta: {
        auth: true,
      },
    },
    {
      path: "/profile/:id/edit",
      name: "editProfile",
      component: () => import("@/views/EditProfileView.vue"),
      meta: {
        auth: true,
      },
    },
    {
      path: "/settings",
      name: "settings",
      component: () => import("@/views/SettingView.vue"),
      meta: {
        auth: true,
      },
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
          meta: {
            auth: true,
          },
        },
        {
          path: ":id",
          name: "groupByID",
          component: () => import("@/views/group/GroupView.vue"),
          meta: {
            auth: true,
          },
        },
        {
          path: ":id/edit",
          name: "groupEdit",
          component: () => import("@/views/group/GroupEditView.vue"),
          meta: {
            auth: true,
          },
        },
      ],
    },
  ],
});

router.beforeEach((to, from, next) => {
  const auth = to.meta.auth;
  const session = JSON.parse(localStorage.getItem("session"));
  const user = (session && session.data) || {};

  if (auth && !user.token) {
    next({ name: "login" });
  } else if (!auth && user.token) {
    next({ name: "home" });
  } else {
    next();
  }
});

export default router;
