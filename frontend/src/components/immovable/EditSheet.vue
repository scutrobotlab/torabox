<template>
  <v-bottom-sheet scrollable v-model="sheet" :inset="!$vuetify.breakpoint.mobile">
    <v-card>
      <v-toolbar>
        <v-toolbar-title>编辑不动产</v-toolbar-title>
        <v-spacer />
        <v-btn icon @click="sheet = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text class="pt-7">
        <ErrorAlert v-model="error" />

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
                v-if="immovable.status == 0 || immovable.status == -1"
                :items="[
                  { name: '正常', value: 0 },
                  { name: '损坏', value: -1 },
                ]"
                item-text="name"
                item-value="value"
                v-model="immovable.status"
                label="状态*"
              ></v-select>
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
  </v-bottom-sheet>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { putImmovable } from "@/api/immovable.js";

export default {
  mixins: [errorMixin],
  props: ["data"],
  data: () => ({
    sheet: false,
    valid: true,
    disabled: false,
    loading: false,
    immovable: {
      id: null,
      name: null,
      status: null,
      description: null,
    },
  }),
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    async save() {
      this.loading = true;
      this.disabled = true;
      await this.errorHandler(putImmovable(this.immovable.id, this.immovable));
      this.$emit("getImmovable");
      this.loading = false;
      this.disabled = false;
      this.sheet = false;
    },
    openSheet() {
      this.immovable = this.data;
      this.sheet = true;
    },
  },
};
</script>

<style></style>
