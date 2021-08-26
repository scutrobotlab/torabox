<template>
  <v-main>
    <v-app-bar app dark color="primary">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>{{ title }}</v-toolbar-title>
      <template v-slot:extension v-if="subRoutes">
        <v-tabs background-color="primary" grow dark>
          <v-tab
            v-for="r in subRoutes"
            :key="r.key"
            :to="`${$router.currentRoute.matched[1].path}/${r.path}`"
          >
            <v-icon>{{ r.meta.icon }}</v-icon>
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-navigation-drawer app width="300" v-model="drawer">
      <v-list v-if="user">
        <v-list-item>
          <v-list-item-avatar>
            <img :src="user.avatar" />
          </v-list-item-avatar>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-h6">{{ user.name }}</v-list-item-title>
            <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-divider />

      <v-list nav>
        <v-list-item v-for="r in routes" :key="r.key" :to="'/dashboard/' + r.path" color="accent">
          <v-list-item-icon>
            <v-icon>
              {{ r.meta.icon }}
            </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{ r.meta.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <template v-slot:append>
        <v-card-actions>
          <v-btn color="accent" outlined :loading="loading" :disabled="loading" @click="logout">
            <v-icon left>mdi-logout</v-icon>登出
          </v-btn>
          <v-spacer />
          <v-btn icon @click="$vuetify.theme.dark = !$vuetify.theme.dark">
            <v-icon>{{ $vuetify.theme.dark ? "mdi-weather-night" : "mdi-weather-sunny" }}</v-icon>
          </v-btn>
        </v-card-actions>
      </template>
    </v-navigation-drawer>

    <router-view />
  </v-main>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    loading: false,
    drawer: null,
    subRoutes: null,
  }),
  async created() {
    Promise.all([this.$store.dispatch("getUser"), this.$store.dispatch("getGroups")]);
    this.getSubRoutes();
  },
  computed: {
    title() {
      return this.$route.meta.title || "物资管理";
    },
    routes() {
      const dashboard = this.$router.options.routes.find((route) => route.path === "/dashboard");
      return dashboard.children.filter((c) => c.meta != null);
    },
    user() {
      return this.$store.state.user;
    },
  },
  watch: {
    $route() {
      this.getSubRoutes();
    },
  },
  methods: {
    async logout() {
      this.loading = true;
      await this.$store.dispatch("deleteUser");
    },
    getSubRoutes() {
      const r = this.routes.find(
        (route) => "/dashboard/" + route.path === this.$router.currentRoute.matched[1].path
      );
      this.subRoutes = r.children.filter((c) => c.meta != null);
    },
  },
};
</script>

<style>
.container {
  display: block;
  max-width: 960px;
}
.blur {
  opacity: 0.7;
  backdrop-filter: blur(10px);
}
.v-app-bar {
  opacity: 0.9;
  backdrop-filter: blur(10px);
}
.v-navigation-drawer {
  opacity: 0.9;
  backdrop-filter: blur(10px);
}
</style>
