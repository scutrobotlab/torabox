<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <v-snackbar top class="mt-5" v-model="snackbar" color="success" dark>
      同步完成
      <template v-slot:action="{ attrs }">
        <v-btn icon text v-bind="attrs" @click="snackbar = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
    <v-fade-transition>
      <v-card v-if="!loading">
        <v-card-text :class="snackbar ? 'pt-12' : ''">
          <UserProfileList :user="user" />
        </v-card-text>
        <v-card-actions>
          <v-btn block color="primary" :loading="loading" :disabled="loading" @click="updateUser">
            <v-icon left dark> mdi-autorenew </v-icon>从统一认证同步信息
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-fade-transition>

    <v-fade-transition>
      <v-card class="mt-3" v-if="notification_count">
        <v-list>
          <v-subheader>不动产</v-subheader>
          <v-list-item to="/dashboard/account/immovable/owned">
            <v-list-item-content>
              <v-list-item-title>
                <v-badge
                  :value="notification_count.immovables_owned"
                  color="blue"
                  :content="notification_count.immovables_owned"
                >
                  我拥有的物资
                </v-badge>
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
          <v-list-item to="/dashboard/account/immovable/application_applied">
            <v-list-item-content>
              <v-list-item-title>
                <v-badge
                  :value="notification_count.immovable_applications_applied"
                  color="green"
                  :content="notification_count.immovable_applications_applied"
                >
                  我发起的申请
                </v-badge>
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
          <v-list-item to="/dashboard/account/immovable/application_approved">
            <v-list-item-content>
              <v-list-item-title>
                <v-badge
                  :value="notification_count.immovable_applications_approved"
                  color="red"
                  :content="notification_count.immovable_applications_approved"
                >
                  我审核的申请
                </v-badge>
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
          <v-divider />
          <v-subheader>消耗品</v-subheader>
          <v-list-item to="/dashboard/account/consumable/application_applied">
            <v-list-item-content>
              <v-list-item-title>
                <v-badge
                  :value="notification_count.consumable_applications_applied"
                  color="green"
                  :content="notification_count.consumable_applications_applied"
                >
                  我发起的申请
                </v-badge>
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
          <v-list-item to="/dashboard/account/consumable/application_approved">
            <v-list-item-content>
              <v-list-item-title>
                <v-badge
                  :value="notification_count.consumable_applications_approved"
                  color="red"
                  :content="notification_count.consumable_applications_approved"
                >
                  我审核的申请
                </v-badge>
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-card>
    </v-fade-transition>
  </v-container>
</template>

<script>
import UserProfileList from "@/components/UserProfileList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getUserSelfNotificationCount } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  components: {
    UserProfileList,
  },
  data: () => ({
    snackbar: false,
    loading: true,
    notification_count: null,
  }),
  computed: {
    user() {
      return this.$store.state.user;
    },
    routes() {
      const r = this.$router.options.routes.find((route) => route.path === "/account");
      return r.children.filter((c) => c.meta != null);
    },
  },
  async created() {
    this.notification_count = await this.errorHandler(getUserSelfNotificationCount());
  },
  mounted() {
    this.loading = false;
  },
  methods: {
    async updateUser() {
      this.loading = true;
      await this.$store.dispatch("updateUser");
      this.snackbar = true;
      this.loading = false;
    },
  },
};
</script>
