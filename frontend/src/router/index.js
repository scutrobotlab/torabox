import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import UserLogin from "@/views/user/Login.vue";
import UserLogout from "@/views/user/Logout.vue";
import UserCallback from "@/views/user/Callback.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/user/login",
    name: "UserLogin",
    component: UserLogin,
  },
  {
    path: "/user/logout",
    name: "UserLogout",
    component: UserLogout,
  },
  {
    path: "/user/callback",
    name: "UserCallback",
    component: UserCallback,
  },
  {
    path: "/dashboard",
    component: () =>
      import(
        /* webpackChunkName: "dashboard-drawer" */
        "../views/dashboard/Drawer.vue"
      ),
    meta: { requiresAuth: true },
    children: [
      {
        path: "main",
        component: () =>
          import(
            /* webpackChunkName: "dashboard-main" */
            "@/views/dashboard/Main.vue"
          ),
      },
      {
        path: "info",
        component: () =>
          import(
            /* webpackChunkName: "dashboard-info" */
            "@/views/dashboard/Info.vue"
          ),
        meta: {
          title: "个人信息",
          icon: "mdi-account-circle",
          msg: "查看个人信息，包括姓名、身份和更多内容。",
          color: "accent",
        },
      },
      {
        path: "subscription",
        component: () =>
          import(
            /* webpackChunkName: "dashboard-subscription-main" */
            "@/views/dashboard/subscription/Main.vue"
          ),
        meta: {
          title: "订阅类",
          icon: "mdi-server",
          msg: "管理订阅类物资",
          color: "orange",
        },
        children: [
          {
            path: "",
            meta: { title: "订阅列表" },
            component: () =>
              import(
                /* webpackChunkName: "dashboard-subscription-list" */
                "@/views/dashboard/subscription/List.vue"
              ),
          },
          {
            path: "new",
            meta: { title: "新增订阅" },
            component: () =>
              import(
                /* webpackChunkName: "dashboard-subscription-new" */
                "@/views/dashboard/subscription/New.vue"
              ),
          },
          {
            path: ":id",
            meta: { title: "订阅详情" },
            component: () =>
              import(
                /* webpackChunkName: "dashboard-subscription-index" */
                "@/views/dashboard/subscription/Index.vue"
              ),
          },
        ],
      },
      {
        path: "/",
        redirect: "main",
      },
    ],
  },
  {
    path: "*",
    redirect: "/dashboard/main",
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!localStorage.getItem("login")) {
      next({
        path: "/user/login",
        query: { redirect: to.fullPath },
      });
    } else {
      let redirect = from.query.redirect;
      if (to.fullPath === redirect) {
        next();
      } else {
        next({ path: redirect });
      }
    }
  } else if (from.query.redirect && !to.query.redirect) {
    next({ path: to.path, query: { redirect: from.query.redirect } });
  } else {
    next();
  }
});

export default router;
