import Vue from "vue";
import Vuex from "vuex";
import router from "@/router";
import { getUserSelf, putUserSelf, deleteUserSelfSession } from "@/api/user.js";
import { getGroups } from "@/api/group.js";
import { getImmovableKinds } from "@/api/immovable_kind.js";
import { getConsumables } from "@/api/consumable.js";

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
    kinds: null,
    consumables: null,
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
    setKinds(state, kinds) {
      state.kinds = kinds;
    },
    setConsumables(state, consumables) {
      state.consumables = consumables;
    },
  },
  actions: {
    getUser({ commit }) {
      getUserSelf().then((resp) => {
        commit("setUser", resp);
      });
    },
    updateUser({ commit }) {
      putUserSelf().then((resp) => {
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
    getKinds({ commit }) {
      getImmovableKinds().then((resp) => {
        commit("setKinds", resp);
      });
    },
    getConsumables({ commit }) {
      getConsumables().then((resp) => {
        commit("setConsumables", resp);
      });
    },
  },
  modules: {},
});
