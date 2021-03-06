<template>
  <v-container>
    <v-fade-transition>
      <v-card v-show="show">
        <v-toolbar>
          <v-btn icon @click="$router.go(-1)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-toolbar-title v-if="subscription">{{ subscription.name }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu offset-y transition="slide-y-transition" v-if="access">
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item link @click="$refs.EditSheet.openSheet()">
                <v-list-item-icon>
                  <v-icon> mdi-pencil</v-icon>
                </v-list-item-icon>
                <v-list-item-title>编辑</v-list-item-title>
              </v-list-item>
              <v-list-item link @click="dialog = true">
                <v-list-item-icon>
                  <v-icon> mdi-delete</v-icon>
                </v-list-item-icon>
                <v-list-item-title>删除</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-toolbar>

        <ErrorAlert v-model="error" />
        <WaitProgress v-if="loading" class="ma-7" />

        <v-list v-else>
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-clock</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>到期时间</v-list-item-subtitle>
              <v-list-item-title>{{ subscription.end_time }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-account</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>负责人</v-list-item-subtitle>
              <v-list-item-title>{{ subscription.user.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-account-multiple</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>归属</v-list-item-subtitle>
              <v-list-item-title>{{ subscription.group.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-text-box</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>描述</v-list-item-subtitle>
              <v-list-item-title>{{ subscription.description }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-history</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>
                入库于 {{ format(subscription.created_at) }}
              </v-list-item-subtitle>
              <v-list-item-subtitle>
                修改于 {{ format(subscription.updated_at) }}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider />

        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card v-if="subscription">
            <v-card-title> 确定删除{{ subscription.name }}？ </v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="error" :disabled="removing" :loading="removing" text @click="remove">
                删除
              </v-btn>
              <v-btn
                color="gray"
                :disabled="removing"
                :loading="removing"
                text
                @click="dialog = false"
              >
                取消
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-card>
    </v-fade-transition>

    <EditSheet
      v-if="!loading"
      :data="subscription"
      ref="EditSheet"
      @getSubscription="getSubscription"
    />
  </v-container>
</template>

<script>
import { format } from "@/utils/moment";
import WaitProgress from "@/components/WaitProgress.vue";
import EditSheet from "@/components/subscription/EditSheet.vue";
import errorMixin from "@/mixins/errorMixin.js";
import {
  getSubscriptionIndex,
  getSubscriptionIndexEdit,
  deleteSubscription,
} from "@/api/subscription.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    EditSheet,
  },
  data: () => ({
    show: false,
    loading: true,
    removing: false,
    dialog: false,
    access: false,
    subscription: null,
  }),
  created() {
    this.loading = true;
    this.errorHandler(Promise.all([this.checkAccess(), this.getSubscription()])).finally(() => {
      this.loading = false;
    });
  },
  mounted() {
    this.show = true;
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    groups() {
      return this.$store.state.groups;
    },
  },
  methods: {
    format,
    async checkAccess() {
      this.access = await this.errorHandler(getSubscriptionIndexEdit(this.$route.params.id));
    },
    async getSubscription() {
      this.subscription = await this.errorHandler(getSubscriptionIndex(this.$route.params.id));
    },
    remove() {
      this.removing = true;
      this.errorHandler(deleteSubscription(this.$route.params.id))
        .then(() => {
          this.$store.dispatch("getSubscriptions");
          this.dialog = false;
          this.removing = false;
          this.$router.push("/dashboard/resource/subscription");
        })
        .catch(() => {
          this.dialog = false;
          this.removing = false;
        });
    },
  },
};
</script>

<style scoped>
.v-list-item__title {
  white-space: pre-line;
  height: fit-content;
}
</style>
