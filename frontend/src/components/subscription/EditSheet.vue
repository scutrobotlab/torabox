<template>
  <v-bottom-sheet scrollable v-model="sheet" :inset="!$vuetify.breakpoint.mobile">
    <v-card>
      <v-toolbar dark>
        <v-toolbar-title>编辑订阅类</v-toolbar-title>
        <v-spacer />
        <v-btn icon dark @click="sheet = false">
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
                v-model="subscription.name"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-menu
                v-model="menu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="subscription.end_time"
                    label="到期时间*"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="subscription.end_time"
                  no-title
                  @input="menu = false"
                  :min="new Date().toISOString()"
                >
                </v-date-picker>
              </v-menu>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-select
                :items="user.groups"
                item-text="name"
                item-value="id"
                :rules="[(v) => !!v || '归属是必要的']"
                v-model="subscription.group_id"
                label="归属*"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field label="负责人*" type="text" disabled :value="user.name"></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-textarea label="描述" v-model="subscription.description" required></v-textarea>
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
import { putSubscription } from "@/api/subscription.js";

export default {
  mixins: [errorMixin],
  props: ["data"],
  data: () => ({
    hidden: true,
    sheet: false,
    menu: false,
    valid: true,
    disabled: false,
    loading: false,
    subscription: {
      id: null,
      name: null,
      end_time: null,
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
  methods: {
    async save() {
      this.loading = true;
      this.disabled = true;
      await this.errorHandler(putSubscription(this.subscription.id, this.subscription));
      this.$emit("getSubscription");
      this.loading = false;
      this.disabled = false;
      this.sheet = false;
    },
    openSheet() {
      this.subscription = this.data;
      this.sheet = true;
    },
  },
};
</script>

<style></style>
