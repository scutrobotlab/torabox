<template>
  <v-bottom-sheet scrollable v-model="sheet" :inset="!$vuetify.breakpoint.mobile">
    <v-card>
      <v-toolbar>
        <v-toolbar-title>编辑消耗品</v-toolbar-title>
        <v-spacer />
        <v-btn icon @click="sheet = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text class="pt-7">
        <ErrorAlert v-model="error" />

        <v-form ref="form" v-model="valid" lazy-validation :disabled="disabled">
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                label="名称*"
                type="text"
                :rules="[(v) => !!v || '名称是必要的']"
                v-model="consumable.name"
                required
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-textarea label="描述" v-model="consumable.description"></v-textarea>
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
import { putConsumable } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  props: ["data"],
  data: () => ({
    sheet: false,
    valid: true,
    disabled: false,
    loading: false,
    consumable: {
      id: null,
      name: null,
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
      this.errorHandler(putConsumable(this.consumable.id, this.consumable))
        .then(() => {
          this.$emit("getConsumable");
          this.sheet = false;
        })
        .finally(() => {
          this.loading = false;
          this.disabled = false;
        });
    },
    openSheet() {
      this.consumable = this.data;
      this.sheet = true;
    },
  },
};
</script>

<style></style>
