import Vue from "vue";
import Vuex from "vuex";
import router from "@/router";
import { getUserSelf, deleteUserSelfSession } from "@/api/user.js";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: {
      id: null,
      email: "",
      name: "",
      avatar: "",
    },
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    clearUser(state) {
      state.user = null;
    },
  },
  actions: {
    getUser({ commit }) {
      getUserSelf().then((resp) => {
        commit("setUser", resp);
      });
    },
    deleteUser({ commit }) {
      deleteUserSelfSession().then(() => {
        commit("clearUser");
        localStorage.removeItem("login");
        router.push("/user/logout");
      });
    },
  },
  modules: {},
});
