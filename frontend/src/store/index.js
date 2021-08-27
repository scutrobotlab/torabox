import Vue from "vue";
import Vuex from "vuex";
import router from "@/router";
import { getUserSelf, putUserSelf, deleteUserSelfSession } from "@/api/user.js";
import { getGroups } from "@/api/group.js";
import { getImmovableKinds } from "@/api/immovable_kind.js";
import { getImmovables } from "@/api/immovable.js";
import { getConsumables } from "@/api/consumable.js";
import { getSubscriptions } from "@/api/subscription.js";

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
    immovables: null,
    consumables: null,
    subscriptions: null,
  },
  getters: {
    searchImmovables: (state) => (keyword) => {
      if (keyword == "") return [];
      if (!state.immovables) return [];
      return state.immovables.filter(function(product) {
        return Object.keys(product).some(function(key) {
          return (
            String(product[key])
              .toLowerCase()
              .indexOf(keyword) > -1
          );
        });
      });
    },
    searchConsumables: (state) => (keyword) => {
      if (keyword == "") return [];
      if (!state.consumables) return [];
      return state.consumables.filter(function(product) {
        return Object.keys(product).some(function(key) {
          return (
            String(product[key])
              .toLowerCase()
              .indexOf(keyword) > -1
          );
        });
      });
    },
    searchSubscriptions: (state) => (keyword) => {
      if (keyword == "") return [];
      if (!state.subscriptions) return [];
      return state.subscriptions.filter(function(product) {
        return Object.keys(product).some(function(key) {
          return (
            String(product[key])
              .toLowerCase()
              .indexOf(keyword) > -1
          );
        });
      });
    },
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
    setImmovables(state, immovables) {
      state.immovables = immovables;
    },
    setConsumables(state, consumables) {
      state.consumables = consumables;
    },
    setSubscriptions(state, subscriptions) {
      state.subscriptions = subscriptions;
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
    getImmovables({ commit }) {
      getImmovables().then((resp) => {
        commit("setImmovables", resp);
      });
    },
    getConsumables({ commit }) {
      getConsumables().then((resp) => {
        commit("setConsumables", resp);
      });
    },
    getSubscriptions({ commit }) {
      getSubscriptions().then((resp) => {
        commit("setSubscriptions", resp);
      });
    },
  },
  modules: {},
});
