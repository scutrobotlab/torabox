<template>
  <v-card>
    <v-toolbar dark color="primary">
      <v-btn icon dark @click="$router.push('/dashboard/subscription')">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>订阅详情</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>
    <v-card-text>
      <v-container>
        <ErrorAlert v-model="error" />
        <WaitProgress v-if="loading" class="mt-10" />
        <v-form v-else ref="form" v-model="valid" lazy-validation :disabled="!access">
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-text-field
                label="名称*"
                type="text"
                :rules="[(v) => !!v || '名称是必要的']"
                v-model="subscription.name"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field
                label="到期时间*"
                type="text"
                :rules="dateRules"
                hint="形如2000-01-01"
                v-model="subscription.end_time"
                required
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-select
                :items="access ? user.groups : groups"
                item-text="name"
                item-value="id"
                :rules="[(v) => !!v || '归属是必要的']"
                v-model="subscription.group_id"
                label="归属*"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field
                label="负责人*"
                type="text"
                disabled
                :value="subscriptionNew ? user.name : subscription.user.name"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-textarea label="描述" v-model="subscription.description" required></v-textarea>
            </v-col>
          </v-row>
        </v-form>
      </v-container>
      <v-card-actions v-if="!loading && access">
        <v-spacer></v-spacer>
        <v-btn color="primary" :disabled="!valid" dark @click="save"> 保存 </v-btn>
        <v-btn color="error" v-if="!subscriptionNew" dark @click="dialog = true"> 删除 </v-btn>
      </v-card-actions>
    </v-card-text>
    <v-dialog v-model="dialog" persistent max-width="290">
      <v-card>
        <v-card-title> 确定删除{{ subscription.name }}？ </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" text @click="remove">删除</v-btn>
          <v-btn color="gray" text @click="dialog = false">取消</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import {
  getSubscriptionIndex,
  getSubscriptionIndexEdit,
  postSubscription,
  putSubscription,
  deleteSubscription,
} from "@/api/subscription.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  props: ["subscriptionNew", "subscriptionId"],
  data: () => ({
    loading: true,
    dialog: false,
    valid: true,
    access: false,
    dateRules: [
      (v) => !!v || "到期时间是必要的",
      (v) => /[0-9]{4}-[0-1][0-9]{1}-[0-3][0-9]{1}/.test(v) || "格式错误，应形如2000-01-01",
    ],
    subscription: {
      id: null,
      name: null,
      end_time: null,
      user: null,
      group_id: null,
      description: null,
    },
  }),
  created() {
    if (this.subscriptionNew) {
      this.access = true;
      this.loading = false;
    } else {
      this.loading = true;
      Promise.all([this.checkAccess(), this.getSubscription()]).finally(() => {
        this.loading = false;
      });
    }
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
    async checkAccess() {
      this.access = await this.errorHandler(getSubscriptionIndexEdit(this.subscriptionId));
    },
    async getSubscription() {
      this.subscription = await this.errorHandler(getSubscriptionIndex(this.subscriptionId));
    },
    async save() {
      if (this.subscriptionNew) {
        await this.errorHandler(postSubscription(this.subscription));
      } else {
        await this.errorHandler(putSubscription(this.subscriptionId, this.subscription));
      }
      this.$router.push("/dashboard/subscription");
    },
    async remove() {
      await this.errorHandler(deleteSubscription(this.subscriptionId));
      this.dialog = false;
      this.$router.push("/dashboard/subscription");
    },
  },
};
</script>

<style></style>
