<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <v-card>
      <v-card-text>
        <UserProfileList :user="user" />
      </v-card-text>
      <v-card-actions>
        <v-btn block color="primary" :loading="loading" :disabled="loading" @click="updateUser">
          <v-icon left dark> mdi-autorenew </v-icon>从统一认证同步信息
        </v-btn>
      </v-card-actions>
    </v-card>
    <v-alert class="mt-5" v-model="alert" border="left" color="success" dark dismissible>
      同步完成
    </v-alert>
  </v-container>
</template>

<script>
import UserProfileList from "@/components/UserProfileList.vue";
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  components: {
    UserProfileList,
  },
  data: () => ({
    alert: false,
    loading: false,
  }),
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    async updateUser() {
      this.loading = true;
      await this.$store.dispatch("updateUser");
      this.alert = true;
      this.loading = false;
    },
  },
};
</script>
