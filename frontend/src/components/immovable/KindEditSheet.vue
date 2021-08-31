<template>
  <v-bottom-sheet scrollable v-model="sheet" :inset="!$vuetify.breakpoint.mobile">
    <v-card>
      <v-toolbar>
        <v-toolbar-title>编辑不动产分类</v-toolbar-title>
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
                v-model="immovable_kind.name"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-select
                :items="user.groups"
                item-text="name"
                item-value="id"
                :rules="[(v) => !!v || '归属是必要的']"
                v-model="immovable_kind.group_id"
                label="归属*"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-textarea label="描述" v-model="immovable_kind.description"></v-textarea>
            </v-col>
          </v-row>
        </v-form>

        <v-card-actions>
          <v-btn
            color="primary"
            :loading="loading"
            :disabled="!valid || disabled"
            block
            @click="save"
          >
            保存
          </v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-bottom-sheet>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { putImmovableKind } from "@/api/immovable_kind.js";

export default {
  mixins: [errorMixin],
  props: ["data"],
  data: () => ({
    sheet: false,
    valid: true,
    disabled: false,
    loading: false,
    immovable_kind: {
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
  },
  methods: {
    save() {
      this.loading = true;
      this.disabled = true;
      this.errorHandler(putImmovableKind(this.immovable_kind.id, this.immovable_kind))
        .then(() => {
          this.$emit("getImmovableKind");
          this.sheet = false;
        })
        .finally(() => {
          this.loading = false;
          this.disabled = false;
        });
    },
    openSheet() {
      this.immovable_kind = this.data;
      this.sheet = true;
    },
  },
};
</script>

<style></style>
