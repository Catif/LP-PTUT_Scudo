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
			path: "/record",
			name: "record",
			component: () => import("@/views/RecordView.vue"),
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
		{
			path: "/group",
			name: "group",
			redirect: "/group/create",
			children: [
				{
					path: "/:id",
					name: "groupByID",
					component: () => import("@/views/group/GroupView.vue"),
				},
				{
					path: "/create",
					name: "groupCreate",
					component: () => import("@/views/group/GroupCreateView.vue"),
				},
				{
					path: "/:id/edit",
					name: "groupEdit",
					component: () => import("@/views/group/GroupEditView.vue"),
				},
			],
		},
	],
});

export default router;
