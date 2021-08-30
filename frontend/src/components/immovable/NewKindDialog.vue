<template>
  <v-dialog
    v-model="dialog"
    :fullscreen="$vuetify.breakpoint.mobile"
    transition="scale-transition"
    origin="bottom right"
    max-width="600px"
  >
    <v-card>
      <v-toolbar dark color="primary">
        <v-toolbar-title>新增不动产分类</v-toolbar-title>
        <v-spacer />
        <v-btn icon dark @click="dialog = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text class="pt-7">
        <ErrorAlert v-model="error" />

        <v-alert text dense color="success" dark v-model="alert" transition="scale-transition">
          <v-row align="center">
            <v-col class="grow"> 添加完成 </v-col>
            <v-col class="shrink">
              <v-btn color="success" outlined @click="continueNew">继续添加</v-btn>
            </v-col>
          </v-row>
        </v-alert>

        <v-form ref="form" v-model="valid" lazy-validation :disabled="disabled">
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-text-field
                label="名称*"
                type="text"
                :rules="[(v) => !!v || '名称是必要的']"
                v-model="Immovable_kind.name"
                required
              ></v-text-field>
            </v-col>
            <v-col v-if="user.groups" cols="12" sm="6" md="6">
              <v-select
                :items="user.groups"
                item-text="name"
                item-value="id"
                :rules="[(v) => !!v || '归属是必要的']"
                v-model="Immovable_kind.group_id"
                label="归属*"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-textarea label="描述" v-model="Immovable_kind.description"></v-textarea>
            </v-col>
          </v-row>
        </v-form>

        <v-card-actions>
          <v-btn
            color="primary"
            :loading="loading"
            :disabled="!valid || disabled"
            block
            dark
            @click="save"
          >
            保存
          </v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { postImmovableKind } from "@/api/immovable_kind.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    hidden: true,
    alert: false,
    dialog: false,
    valid: true,
    disabled: false,
    loading: false,
    Immovable_kind: {
      id: null,
      name: null,
      group_id: null,
      description: null,
    },
  }),
  computed: {
    user() {
      return this.$store.state.user;
    },
    kinds() {
      return this.$store.state.kinds;
    },
  },
  methods: {
    openDialog() {
      this.dialog = true;
      this.hidden = false;
    },
    save() {
      this.loading = true;
      this.disabled = true;
      this.errorHandler(postImmovableKind(this.Immovable_kind))
        .then(() => {
          this.$store.dispatch("getKinds");
          this.alert = true;
        })
        .catch(() => {
          this.disabled = false;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    continueNew() {
      this.alert = false;
      this.$refs.form.reset();
      this.disabled = false;
    },
  },
};
</script>

<style></style>
