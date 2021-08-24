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
