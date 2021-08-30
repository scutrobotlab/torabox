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
        <v-toolbar-title>新增订阅类</v-toolbar-title>
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
                    :rules="[(v) => !!v || '到期时间是必要的']"
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
              <v-textarea label="描述" v-model="subscription.description"></v-textarea>
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
import { postSubscription } from "@/api/subscription.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    hidden: true,
    alert: false,
    dialog: false,
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
  mounted() {
    this.hidden = false;
  },
  methods: {
    save() {
      this.loading = true;
      this.disabled = true;
      this.errorHandler(postSubscription(this.subscription))
        .then(() => {
          this.$store.dispatch("getSubscriptions");
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
