<template>
  <div v-if="user">
    <ErrorAlert v-model="error" />
    <div class="d-block text-center">
      <v-avatar size="80" class="elevation-1">
        <v-img :src="user.avatar"></v-img>
      </v-avatar>
    </div>
    <v-card-title class="d-block text-center"> 欢迎使用，{{ user.name }} </v-card-title>
    <v-card-subtitle class="d-block text-center">
      从这里开始，管理您的百宝箱
    </v-card-subtitle>
    <v-row>
      <v-col cols="12" sm="6" v-for="r in routes" :key="r.key">
        <v-card class="mx-auto" outlined :to="r.path">
          <v-list-item three-line>
            <v-list-item-content>
              <v-list-item-title class="headline">{{ r.meta.title }}</v-list-item-title>
              <v-list-item-subtitle class="subtitle-2">{{ r.meta.msg }}</v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-avatar tile size="80">
              <v-icon size="80" :color="r.meta.color">{{ r.meta.icon }}</v-icon>
            </v-list-item-avatar>
          </v-list-item>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  computed: {
    routes() {
      const dashboard = this.$router.options.routes.find((route) => route.path === "/dashboard");
      return dashboard.children.filter(
        (c) => c.meta && (this.$store.state.user.id === 1 || !c.meta.requiresSuperAdmin)
      );
    },
    user() {
      return this.$store.state.user;
    },
  },
};
</script>

<style></style>
