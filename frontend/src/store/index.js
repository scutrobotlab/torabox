import Vue from "vue";
import Vuex from "vuex";
import router from "@/router";
import { getUserSelf, deleteUserSelfSession } from "@/api/user.js";
import { getGroups } from "@/api/group.js";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: {
      id: null,
      email: "",
      name: "",
      avatar: "",
      groups: null,
    },
    groups: null,
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    clearUser(state) {
      state.user = null;
    },
    setGroups(state, groups) {
      state.groups = groups;
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
    getGroups({ commit }) {
      getGroups().then((resp) => {
        commit("setGroups", resp);
      });
    },
  },
  modules: {},
});
