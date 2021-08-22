<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <v-alert v-if="$route.params.id === ':id'" prominent type="warning">
      <v-row align="center">
        <v-col class="grow">请选择一个消耗品</v-col>
        <v-col class="shrink">
          <v-btn outlined to="/dashboard/consumable">返回</v-btn>
        </v-col>
      </v-row>
    </v-alert>
    <WaitProgress v-else-if="loading" class="ma-7" />
    <v-card v-else>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="$router.push('/dashboard/consumable')">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        <v-toolbar-title v-if="consumable">{{ consumable.name }}</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-list>
            <v-subheader>基本信息</v-subheader>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  {{ consumable.need_approval ? "需要审批" : "无需审批" }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>剩余数量：{{ consumable.number }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>负责人：{{ consumable.user.name }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>归属：{{ consumable.group.name }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>描述：{{ consumable.description }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          <v-list>
            <v-subheader>相关记录</v-subheader>
            <v-list-item :to="`/dashboard/consumable/${$route.params.id}/application`">
              <v-list-item-content>
                <v-list-item-title>申请记录</v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-icon>mdi-chevron-right</v-icon>
              </v-list-item-action>
            </v-list-item>
            <v-list-item :to="`/dashboard/consumable/${$route.params.id}/purchase`">
              <v-list-item-content>
                <v-list-item-title>购买记录</v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-icon>mdi-chevron-right</v-icon>
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-container>
        <v-card-actions v-if="access">
          <v-spacer></v-spacer>
          <v-btn color="error" v-if="access" dark block @click="dialog = true">删除</v-btn>
        </v-card-actions>
      </v-card-text>

      <v-dialog v-model="dialog" persistent max-width="290">
        <v-card v-if="consumable">
          <v-card-title> 确定删除{{ consumable.name }}？ </v-card-title>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error" text @click="remove">删除</v-btn>
            <v-btn color="gray" text @click="dialog = false">取消</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableIndex, getConsumableIndexEdit, deleteConsumable } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  data: () => ({
    loading: true,
    dialog: false,
    access: false,
    consumable: null,
  }),
  created() {
    if (this.$route.params.id !== ":id") {
      this.loading = true;
      Promise.all([this.checkAccess(), this.getConsumable()]).finally(() => {
        this.loading = false;
      });
    } else {
      this.loading = false;
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
      this.access = await this.errorHandler(getConsumableIndexEdit(this.$route.params.id));
    },
    async getConsumable() {
      this.consumable = await this.errorHandler(getConsumableIndex(this.$route.params.id));
    },
    async remove() {
      await this.errorHandler(deleteConsumable(this.$route.params.id));
      this.dialog = false;
      this.$router.push("/dashboard/consumable");
    },
  },
};
</script>

<style></style>
