<template>
  <v-main>
    <v-app-bar app dark color="primary">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>{{ title }}</v-toolbar-title>
    </v-app-bar>

    <v-navigation-drawer width="300" v-model="drawer" app>
      <v-list-item to="/dashboard/main" color="accent" v-if="user">
        <v-list-item-avatar tile>
          <img :src="user.avatar" />
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title>{{ user.name }}</v-list-item-title>
          <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-divider />
      <v-list dense nav>
        <div v-for="r in routes" :key="r.key">
          <div v-if="r.meta && (!r.meta.requiresSuperAdmin || user.id === 1)">
            <v-list-group
              v-if="r.children"
              :prepend-icon="r.meta.icon"
              :value="$route.path.startsWith('/dashboard/' + r.path)"
              @click="RoutePush(r.path)"
              color="accent"
            >
              <template v-slot:activator>
                <v-list-item-title>{{ r.meta.title }}</v-list-item-title>
              </template>
              <v-list-item
                v-for="c in r.children"
                :key="c.key"
                :to="'/dashboard/' + r.path + '/' + c.path"
                color="accent"
              >
                <v-list-item-icon>{{ c.meta.icon }}</v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>{{ c.meta.title }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-group>
            <v-list-item v-else :to="'/dashboard/' + r.path" color="accent">
              <v-list-item-icon>
                <v-icon>{{ r.meta.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ r.meta.title }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </div>
        </div>
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
    <router-view class="mt-3" />
  </v-main>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    loading: false,
    drawer: null,
  }),
  async created() {
    await this.$store.dispatch("getUser");
    await this.$store.dispatch("getGroups");
  },
  computed: {
    title() {
      return this.$route.meta.title || "物资管理";
    },
    routes() {
      var dashboard = this.$router.options.routes.find((route) => route.path === "/dashboard");
      return dashboard.children;
    },
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    async logout() {
      this.loading = true;
      await this.$store.dispatch("deleteUser");
    },
    RoutePush(path) {
      if (this.$route.path != "/dashboard/" + path) this.$router.push("/dashboard/" + path);
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
