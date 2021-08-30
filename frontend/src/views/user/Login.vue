<template>
  <v-main>
    <v-container class="fill-height" fluid>
      <ErrorAlert critical v-model="error" />
      <WaitProgress v-if="loading" :text="text" />
      <v-row v-else align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
          <v-alert type="warning"> 测试环境登录 </v-alert>
          <v-card class="elevation-12">
            <v-tabs v-model="tab" fixed-tabs background-color="primary" icons-and-text>
              <v-tabs-slider color="secondary"></v-tabs-slider>
              <v-tab href="#tab-login">
                统一认证
                <v-icon>mdi-account-key</v-icon>
              </v-tab>
              <v-tab href="#tab-fake">
                测试用户
                <v-icon>mdi-account-alert</v-icon>
              </v-tab>
            </v-tabs>
            <v-tabs-items v-model="tab">
              <v-tab-item value="tab-login">
                <v-card-text class="text-center">
                  <v-btn color="primary" @click="login()">
                    <div class="white--text">登录</div>
                  </v-btn>
                </v-card-text>
              </v-tab-item>
              <v-tab-item value="tab-fake">
                <FakeLogin :users="users" />
              </v-tab-item>
            </v-tabs-items>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import FakeLogin from "@/components/FakeLogin.vue";
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConfig } from "@/api/config.js";
import { createUserOAuthURL, getFakeUsers } from "@/api/user.js";

export default {
  components: {
    FakeLogin,
    WaitProgress,
  },
  mixins: [errorMixin],
  data: () => ({
    tab: null,
    text: "请稍后...",
    loading: true,
    config: null,
    users: null,
  }),
  async created() {
    this.config = await this.errorHandler(getConfig());
    if (this.config.is_production) {
      this.text = "正在登录";
      this.login();
    }
    this.users = await getFakeUsers();
    this.loading = false;
  },
  methods: {
    login() {
      const url = createUserOAuthURL(this.config, this.$route.query.redirect);
      document.location.replace(url);
    },
  },
};
</script>

<style></style>
