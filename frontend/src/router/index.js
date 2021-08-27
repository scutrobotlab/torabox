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
        "@/views/dashboard/Drawer.vue"
      ),
    meta: { requiresAuth: true },
    children: [
      {
        path: "/",
        redirect: "resource",
      },
      {
        path: "resource",
        component: () =>
          import(
            /* webpackChunkName: "dashboard-resource-main" */
            "@/views/dashboard/resource/Main.vue"
          ),
        meta: {
          title: "物资",
          icon: "mdi-package-variant-closed",
        },
        children: [
          {
            path: "",
            redirect: "immovable",
          },
          {
            path: "immovable",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-resource-immovable-main" */
                "@/views/dashboard/resource/immovable/Main.vue"
              ),
            meta: {
              title: "不动产",
              icon: "mdi-diamond-stone",
            },
            children: [
              {
                path: "",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-resource-immovable-list" */
                    "@/views/dashboard/resource/immovable/List.vue"
                  ),
                meta: {
                  title: "不动产",
                },
              },
              {
                path: ":id",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-resource-immovable-indexmain" */
                    "@/views/dashboard/resource/immovable/IndexMain.vue"
                  ),
                children: [
                  {
                    path: "",
                    component: () =>
                      import(
                        /* webpackChunkName: "dashboard-resource-immovable-index" */
                        "@/views/dashboard/resource/immovable/Index.vue"
                      ),
                    meta: {
                      title: "不动产详情",
                    },
                  },
                  {
                    path: "application",
                    component: () =>
                      import(
                        /* webpackChunkName: "dashboard-resource-immovable-application" */
                        "@/views/dashboard/resource/immovable/Application.vue"
                      ),
                    meta: {
                      title: "不动产记录",
                    },
                  },
                ],
              },
            ],
          },
          {
            path: "consumable",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-resource-consumable-main" */
                "@/views/dashboard/resource/consumable/Main.vue"
              ),
            meta: {
              title: "消耗品",
              icon: "mdi-nut",
            },
            children: [
              {
                path: "",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-resource-consumable-list" */
                    "@/views/dashboard/resource/consumable/List.vue"
                  ),
                meta: {
                  title: "消耗品",
                },
              },
              {
                path: ":id",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-resource-consumable-indexmain" */
                    "@/views/dashboard/resource/consumable/IndexMain.vue"
                  ),
                children: [
                  {
                    path: "",
                    component: () =>
                      import(
                        /* webpackChunkName: "dashboard-resource-consumable-index" */
                        "@/views/dashboard/resource/consumable/Index.vue"
                      ),
                    meta: {
                      title: "消耗品详情",
                    },
                  },
                  {
                    path: "application",
                    component: () =>
                      import(
                        /* webpackChunkName: "dashboard-resource-consumable-application" */
                        "@/views/dashboard/resource/consumable/Application.vue"
                      ),
                    meta: {
                      title: "消耗品申请记录",
                    },
                  },
                  {
                    path: "purchase",
                    component: () =>
                      import(
                        /* webpackChunkName: "dashboard-resource-consumable-purchase" */
                        "@/views/dashboard/resource/consumable/Purchase.vue"
                      ),
                    meta: {
                      title: "消耗品购买记录",
                    },
                  },
                ],
              },
            ],
          },
          {
            path: "subscription",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-resource-subscription-main" */
                "@/views/dashboard/resource/subscription/Main.vue"
              ),
            meta: {
              title: "订阅类",
              icon: "mdi-server",
            },
            children: [
              {
                path: "",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-resource-subscription-list" */
                    "@/views/dashboard/resource/subscription/List.vue"
                  ),
                meta: {
                  title: "订阅类",
                },
              },
              {
                path: ":id",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-resource-subscription-index" */
                    "@/views/dashboard/resource/subscription/Index.vue"
                  ),
                meta: {
                  title: "订阅类详情",
                },
              },
            ],
          },
        ],
      },

      {
        path: "application",
        component: () =>
          import(
            /* webpackChunkName: "dashboard-application-main" */
            "@/views/dashboard/application/Main.vue"
          ),
        meta: {
          title: "申请",
          icon: "mdi-list-status",
        },
        children: [
          {
            path: "",
            redirect: "immovable",
          },
          {
            path: "immovable",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-application-immovable-main" */
                "@/views/dashboard/application/immovable/Main.vue"
              ),
            meta: {
              title: "不动产申请",
              icon: "mdi-diamond-stone",
            },
            children: [
              {
                path: "",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-application-immovable-list" */
                    "@/views/dashboard/application/immovable/List.vue"
                  ),
                meta: {
                  title: "不动产申请",
                },
              },
              {
                path: ":id",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-application-immovable-index" */
                    "@/views/dashboard/application/immovable/Index.vue"
                  ),
                meta: {
                  title: "不动产申请详情",
                },
              },
            ],
          },
          {
            path: "consumable",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-application-consumable-main" */
                "@/views/dashboard/application/consumable/Main.vue"
              ),
            meta: {
              title: "消耗品申请",
              icon: "mdi-nut",
            },
            children: [
              {
                path: "",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-application-consumable-list" */
                    "@/views/dashboard/application/consumable/List.vue"
                  ),
                meta: {
                  title: "消耗品申请",
                },
              },
              {
                path: ":id",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-application-consumable-index" */
                    "@/views/dashboard/application/consumable/Index.vue"
                  ),
                meta: {
                  title: "消耗品申请详情",
                },
              },
            ],
          },
        ],
      },
      {
        path: "search",
        component: () =>
          import(
            /* webpackChunkName: "dashboard-search-main" */
            "@/views/dashboard/search/Main.vue"
          ),
        meta: {
          title: "搜索",
          icon: "mdi-magnify",
        },
      },
      {
        path: "account",
        component: () =>
          import(
            /* webpackChunkName: "dashboard-account-main" */
            "@/views/dashboard/account/Main.vue"
          ),
        meta: {
          title: "我的",
          icon: "mdi-account",
        },
        children: [
          {
            path: "",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-account-info" */
                "@/views/dashboard/account/Info.vue"
              ),
            meta: {
              title: "我的",
            },
          },
          {
            path: "immovable",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-account-immovable-main" */
                "@/views/dashboard/account/immovable/Main.vue"
              ),
            meta: {
              title: "我的不动产",
            },
            children: [
              {
                path: "owned",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-account-immovable-owned" */
                    "@/views/dashboard/account/immovable/Owned.vue"
                  ),
                meta: {
                  title: "我的拥有的物资",
                },
              },
              {
                path: "application_applied",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-account-immovable-application-applied" */
                    "@/views/dashboard/account/immovable/ApplicationApplied.vue"
                  ),
                meta: {
                  title: "我发起的申请",
                },
              },
              {
                path: "application_approved",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-account-immovable-application_approved" */
                    "@/views/dashboard/account/immovable/ApplicationApproved.vue"
                  ),
                meta: {
                  title: "我审核的申请",
                },
              },
            ],
          },
          {
            path: "consumable",
            component: () =>
              import(
                /* webpackChunkName: "dashboard-account-consumable-main" */
                "@/views/dashboard/account/consumable/Main.vue"
              ),
            meta: {
              title: "我的消耗品",
            },
            children: [
              {
                path: "application_applied",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-account-consumable-application-applied" */
                    "@/views/dashboard/account/consumable/ApplicationApplied.vue"
                  ),
                meta: {
                  title: "我发起的申请",
                },
              },
              {
                path: "application_approved",
                component: () =>
                  import(
                    /* webpackChunkName: "dashboard-account-consumable-application_approved" */
                    "@/views/dashboard/account/consumable/ApplicationApproved.vue"
                  ),
                meta: {
                  title: "我审核的申请",
                },
              },
            ],
          },
        ],
      },
    ],
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
