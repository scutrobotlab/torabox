<template>
  <v-container>
    <v-fade-transition>
      <v-card v-show="show">
        <v-toolbar v-if="immovable">
          <v-btn icon @click="$router.go(-1)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-toolbar-title>{{ immovable.name }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon @click="$refs.QrcodeDialog.showQrcode()"><v-icon>mdi-qrcode</v-icon></v-btn>
          <v-menu
            offset-y
            transition="slide-y-transition"
            v-if="access || immovable.status == 0 || immovable.owner_id == user.id"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item
                v-if="immovable.status == 0"
                link
                @click="$refs.ApplicationDialog.openDialog()"
              >
                <v-list-item-icon>
                  <v-icon> mdi-cloud-download </v-icon>
                </v-list-item-icon>
                <v-list-item-title>借出</v-list-item-title>
              </v-list-item>

              <v-list-item
                v-if="immovable.status == 1 && immovable.owner_id == user.id"
                link
                @click="$refs.ApplicationDialog.openDialog()"
              >
                <v-list-item-icon>
                  <v-icon> mdi-cloud-upload </v-icon>
                </v-list-item-icon>
                <v-list-item-title>还回</v-list-item-title>
              </v-list-item>

              <v-list-item v-if="access" link @click="$refs.EditSheet.openSheet()">
                <v-list-item-icon>
                  <v-icon> mdi-pencil</v-icon>
                </v-list-item-icon>
                <v-list-item-title>编辑</v-list-item-title>
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
                {{ immovable.need_approval ? "需要审批" : "无需审批" }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>{{ immovable.status_text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>负责人：{{ immovable.user.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>类别：{{ immovable.kind.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>归属：{{ immovable.group.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>描述：{{ immovable.description }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider />

        <v-list>
          <v-subheader>相关记录</v-subheader>
          <v-list-item :to="`/dashboard/resource/immovable/${$route.params.id}/application`">
            <v-list-item-content>
              <v-list-item-title>申请记录</v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
        </v-list>

        <ApplicationDialog ref="ApplicationDialog" @getImmovable="getImmovable" />
        <QrcodeDialog ref="QrcodeDialog" :qrcode-content="qrcodeContent" />

        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card v-if="immovable">
            <v-card-title> 确定删除{{ immovable.name }}？ </v-card-title>
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

    <EditSheet v-if="!loading" :data="immovable" ref="EditSheet" @getImmovable="getImmovable" />
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import QrcodeDialog from "@/components/QrcodeDialog.vue";
import ApplicationDialog from "@/components/immovable/ApplicationDialog.vue";
import EditSheet from "@/components/immovable/EditSheet.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getImmovableIndex, getImmovableIndexEdit, deleteImmovable } from "@/api/immovable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationDialog,
    EditSheet,
    QrcodeDialog,
  },
  data: () => ({
    show: false,
    loading: true,
    removing: false,
    dialog: false,
    access: false,
    immovable: null,
    qrcodeContent: "",
  }),
  created() {
    this.loading = true;
    this.errorHandler(Promise.all([this.checkAccess(), this.getImmovable()])).finally(() => {
      this.loading = false;
    });
    this.qrcodeContent = window.location.origin + "/immovable/" + this.immovable.uuid;
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
      this.access = await this.errorHandler(getImmovableIndexEdit(this.$route.params.id));
    },
    async getImmovable() {
      this.immovable = await this.errorHandler(getImmovableIndex(this.$route.params.id));
    },
    remove() {
      this.removing = true;
      this.errorHandler(deleteImmovable(this.$route.params.id))
        .then(() => {
          this.$store.dispatch("getImmovables");
          this.dialog = false;
          this.removing = false;
          this.$router.push("/dashboard/resource/immovable");
        })
        .catch(() => {
          this.dialog = false;
          this.removing = false;
        });
    },
  },
};
</script>

<style></style>
