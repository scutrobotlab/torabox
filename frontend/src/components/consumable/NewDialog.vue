<template>
  <v-dialog
    v-model="dialog"
    :fullscreen="$vuetify.breakpoint.mobile"
    transition="scale-transition"
    origin="bottom right"
    max-width="600px"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-fab-transition>
        <v-btn
          class="mb-7 mr-3"
          color="secondary"
          v-show="!hidden"
          fab
          fixed
          dark
          bottom
          right
          v-bind="attrs"
          v-on="on"
        >
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-fab-transition>
    </template>

    <v-card>
      <v-toolbar dark color="primary">
        <v-toolbar-title>新增消耗品</v-toolbar-title>
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
                v-model="consumable.name"
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
                v-model="consumable.need_approval"
                label="审批需求*"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col v-if="user.groups" cols="12" sm="6" md="6">
              <v-select
                :items="user.groups"
                item-text="name"
                item-value="id"
                :rules="[(v) => !!v || '归属是必要的']"
                v-model="consumable.group_id"
                label="归属*"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field label="负责人*" type="text" disabled :value="user.name"></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-textarea label="描述" v-model="consumable.description" required></v-textarea>
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
import { postConsumable } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    hidden: true,
    alert: false,
    dialog: false,
    valid: true,
    disabled: false,
    loading: false,
    consumable: {
      id: null,
      name: null,
      need_approval: null,
      user: null,
      group_id: null,
      description: null,
    },
  }),
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
  mounted() {
    this.hidden = false;
  },
  methods: {
    async save() {
      this.loading = true;
      this.disabled = true;
      await this.errorHandler(postConsumable(this.consumable));
      this.$store.dispatch("getConsumables");
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
