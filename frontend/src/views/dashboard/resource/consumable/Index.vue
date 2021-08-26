<template>
  <v-container>
    <v-fade-transition>
      <v-card v-show="show">
        <v-toolbar>
          <v-btn icon @click="$router.go(-1)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-toolbar-title v-if="consumable">{{ consumable.name }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu offset-y transition="slide-y-transition">
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item link @click="$refs.ApplicationDialog.openDialog()">
                <v-list-item-icon>
                  <v-icon> mdi-tools </v-icon>
                </v-list-item-icon>
                <v-list-item-title>申请</v-list-item-title>
              </v-list-item>

              <v-list-item link @click="$refs.PurchaseDialog.openDialog()">
                <v-list-item-icon>
                  <v-icon> mdi-cart </v-icon>
                </v-list-item-icon>
                <v-list-item-title>购买</v-list-item-title>
              </v-list-item>

              <v-list-item link v-if="access" @click="dialog = true">
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

        <v-divider />

        <v-list>
          <v-subheader>相关记录</v-subheader>
          <v-list-item :to="`/dashboard/resource/consumable/${$route.params.id}/application`">
            <v-list-item-content>
              <v-list-item-title>申请记录</v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
          <v-list-item :to="`/dashboard/resource/consumable/${$route.params.id}/purchase`">
            <v-list-item-content>
              <v-list-item-title>购买记录</v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
        </v-list>

        <ApplicationDialog ref="ApplicationDialog" @getConsumable="getConsumable" />
        <PurchaseDialog ref="PurchaseDialog" @getConsumable="getConsumable" />

        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card v-if="consumable">
            <v-card-title> 确定删除{{ consumable.name }}？ </v-card-title>
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
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ApplicationDialog from "@/components/consumable/ApplicationDialog.vue";
import PurchaseDialog from "@/components/consumable/PurchaseDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableIndex, getConsumableIndexEdit, deleteConsumable } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationDialog,
    PurchaseDialog,
  },
  data: () => ({
    show: false,
    loading: true,
    removing: false,
    dialog: false,
    access: false,
    consumable: null,
  }),
  created() {
    this.loading = true;
    Promise.all([this.checkAccess(), this.getConsumable()]).finally(() => {
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
    async checkAccess() {
      this.access = await this.errorHandler(getConsumableIndexEdit(this.$route.params.id));
    },
    async getConsumable() {
      this.consumable = await this.errorHandler(getConsumableIndex(this.$route.params.id));
    },
    async remove() {
      this.removing = true;
      await this.errorHandler(deleteConsumable(this.$route.params.id));
      await this.$store.dispatch("getConsumables");
      this.dialog = false;
      this.removing = false;
      this.$router.push("/dashboard/resource/consumable");
    },
  },
};
</script>

<style></style>
