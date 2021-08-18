<template>
  <v-card-text class="text-center">
    <v-select
      :items="users"
      item-text="name"
      item-value="id"
      :disabled="userSelected"
      v-model="userId"
      @change="getFakeUserIndex(userId - 1)"
      label="选择用户"
    ></v-select>
    <UserProfileList :user="user" />
    <v-btn
      block
      color="primary"
      @click="fakeLogin(userId)"
      :loading="userSelected"
      :disabled="userSelected"
    >
      <div class="white--text">登录</div>
    </v-btn>
  </v-card-text>
</template>

<script>
import UserProfileList from "@/components/UserProfileList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getFakeUsers, getFakeUserIndex, postFakeUserSelfSession } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  components: {
    UserProfileList,
  },
  props: ["users"],
  data: () => ({
    user: null,
    userId: null,
    userSelected: false,
  }),
  methods: {
    async fakeLogin(id) {
      this.userSelected = true;
      const user = await this.errorHandler(postFakeUserSelfSession(id));
      this.userSelected = false;
      if (user) {
        localStorage.setItem("login", true);
        this.$router.push("/dashboard/main");
      }
    },
    async getFakeUsers() {
      this.userList = await this.errorHandler(getFakeUsers());
    },
    async getFakeUserIndex(id) {
      this.user = await this.errorHandler(getFakeUserIndex(id));
    },
  },
};
</script>

<style></style>
