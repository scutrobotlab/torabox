<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <v-snackbar top class="mt-5" v-model="snackbar" color="success">
      同步完成
      <template v-slot:action="{ attrs }">
        <v-btn icon text v-bind="attrs" @click="snackbar = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>

    <WaitProgress v-if="loading" class="ma-7" />
    <v-fade-transition>
      <v-card v-if="!loading">
        <v-card-text :class="snackbar ? 'pt-12' : ''">
          <UserProfileList :user="user" />
        </v-card-text>
        <v-card-actions>
          <v-btn block color="primary" :loading="updating" :disabled="updating" @click="updateUser">
            <v-icon left> mdi-autorenew </v-icon>从统一认证同步信息
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-fade-transition>

    <WaitProgress v-if="loading" class="ma-7" />
    <v-fade-transition>
      <v-card class="mt-3" v-if="notification_count">
        <v-list v-for="r in routes" :key="r.key">
          <v-subheader>{{ r.meta.title }}</v-subheader>
          <v-list-item
            v-for="c in r.children"
            :key="c.key"
            :to="`/dashboard/account/${r.path}/${c.path}`"
          >
            <v-list-item-content>
              <v-list-item-title>
                <v-badge
                  :value="notification_count[c.meta.badgeKey]"
                  :color="c.meta.badgeColor"
                  :content="notification_count[c.meta.badgeKey]"
                >
                  {{ c.meta.title }}
                </v-badge>
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
          <v-divider />
        </v-list>
      </v-card>
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import UserProfileList from "@/components/UserProfileList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getUserSelfNotificationCount } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    UserProfileList,
  },
  data: () => ({
    snackbar: false,
    loading: true,
    updating: false,
    notification_count: null,
  }),
  computed: {
    user() {
      return this.$store.state.user;
    },
    routes() {
      const r = this.$router.options.routes.find((route) => route.path === "/dashboard");
      const c = r.children.filter((c) => c.path === "account");
      return c[0].children.filter((c) => c.path !== "");
    },
  },
  async created() {
    this.notification_count = await this.errorHandler(getUserSelfNotificationCount());
    this.loading = false;
  },
  methods: {
    updateUser() {
      this.updating = true;
      this.errorHandler(this.$store.dispatch("updateUser"))
        .then(() => {
          this.snackbar = true;
        })
        .finally(() => {
          this.updating = false;
        });
    },
  },
};
</script>
