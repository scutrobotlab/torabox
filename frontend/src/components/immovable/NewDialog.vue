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
        <v-toolbar-title>新增不动产</v-toolbar-title>
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
                v-model="immovable.name"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-select
                :items="[
                  { id: 1, name: '是' },
                  { id: 0, name: '否' },
                ]"
                item-text="name"
                item-value="id"
                v-model="immovable.need_approval"
                label="审批需求*"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-select
                :items="kinds"
                item-text="name"
                item-value="id"
                :rules="[(v) => !!v || '种类是必要的']"
                v-model="immovable.immovable_kind_id"
                label="种类*"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field label="负责人*" type="text" disabled :value="user.name"></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-textarea label="描述" v-model="immovable.description" required></v-textarea>
            </v-col>
          </v-row>
        </v-form>

        <v-card-actions>
          <v-btn color="primary" :loading="loading" :disabled="disabled" block dark @click="save">
            保存
          </v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { postImmovable } from "@/api/immovable.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    hidden: true,
    alert: false,
    dialog: false,
    valid: true,
    disabled: false,
    loading: false,
    immovable: {
      id: null,
      name: null,
      need_approval: null,
      user: null,
      immovable_kind_id: null,
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
    async save() {
      this.loading = true;
      this.disabled = true;
      await this.errorHandler(postImmovable(this.immovable));
      this.$store.dispatch("getImmovables");
      this.loading = false;
      this.alert = true;
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
