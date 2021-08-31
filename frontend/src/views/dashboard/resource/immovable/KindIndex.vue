<template>
  <v-container>
    <v-fade-transition>
      <v-card v-show="show">
        <v-toolbar v-if="immovable_kind">
          <v-btn icon @click="$router.go(-1)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-toolbar-title>{{ immovable_kind.name }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu offset-y transition="slide-y-transition" v-if="access">
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
            <v-list>
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
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-account-multiple</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>归属</v-list-item-subtitle>
              <v-list-item-title>{{ immovable_kind.group.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-text-box</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>描述</v-list-item-subtitle>
              <v-list-item-title>{{ immovable_kind.description }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-check-circle-outline</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>在库</v-list-item-subtitle>
              <v-list-item-title>{{ immovable_count(0) }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-close-circle-outline</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>损坏</v-list-item-subtitle>
              <v-list-item-title>{{ immovable_count(-1) }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-alert-circle-outline</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>借出</v-list-item-subtitle>
              <v-list-item-title>{{ immovable_count(1) }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-avatar>
              <v-icon> mdi-history</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-subtitle>
                创建于 {{ format(immovable_kind.created_at) }}
              </v-list-item-subtitle>
              <v-list-item-subtitle>
                修改于 {{ format(immovable_kind.updated_at) }}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider />

        <ListItem :immovables="immovables" v-if="!loading">
          <v-subheader>物品</v-subheader>
        </ListItem>

        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card v-if="immovable_kind">
            <v-card-title> 确定删除{{ immovable_kind.name }}？ </v-card-title>
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

    <KindEditSheet
      v-if="!loading"
      :data="immovable_kind"
      ref="EditSheet"
      @getImmovableKind="getImmovableKind"
    />
  </v-container>
</template>

<script>
import { format } from "@/utils/moment";
import WaitProgress from "@/components/WaitProgress.vue";
import ListItem from "@/components/immovable/ListItem.vue";
import KindEditSheet from "@/components/immovable/KindEditSheet.vue";
import errorMixin from "@/mixins/errorMixin.js";
import {
  getImmovableKindIndex,
  getImmovableKindIndexEdit,
  deleteImmovableKind,
  getImmovableKindIndexImmovables,
} from "@/api/immovable_kind.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ListItem,
    KindEditSheet,
  },
  data: () => ({
    show: false,
    loading: true,
    removing: false,
    dialog: false,
    access: false,
    immovables: null,
    immovable_kind: null,
  }),
  created() {
    this.loading = true;
    this.errorHandler(
      Promise.all([this.checkAccess(), this.getImmovableKind(), this.getImmovable()])
    ).finally(() => {
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
    immovable_count(status) {
      return this.immovables.filter((c) => c.status == status).length;
    },
    async checkAccess() {
      this.access = await this.errorHandler(getImmovableKindIndexEdit(this.$route.params.id));
    },
    async getImmovable() {
      this.immovables = await this.errorHandler(
        getImmovableKindIndexImmovables(this.$route.params.id)
      );
    },
    async getImmovableKind() {
      this.immovable_kind = await this.errorHandler(getImmovableKindIndex(this.$route.params.id));
    },
    remove() {
      this.removing = true;
      this.errorHandler(deleteImmovableKind(this.$route.params.id))
        .then(() => {
          this.$store.dispatch("getKinds");
          this.$store.dispatch("getImmovables");
          this.dialog = false;
          this.removing = false;
          this.$router.push("/dashboard/resource/immovable_kind");
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
