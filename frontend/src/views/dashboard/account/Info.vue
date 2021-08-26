<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <v-snackbar top class="mt-5" v-model="snackbar" color="success" dark>
      同步完成
      <template v-slot:action="{ attrs }">
        <v-btn icon text v-bind="attrs" @click="snackbar = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
    <v-fade-transition>
      <v-card>
        <v-card-text :class="snackbar ? 'pt-12' : ''">
          <UserProfileList :user="user" />
        </v-card-text>
        <v-card-actions>
          <v-btn block color="primary" :loading="loading" :disabled="loading" @click="updateUser">
            <v-icon left dark> mdi-autorenew </v-icon>从统一认证同步信息
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-fade-transition>
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
    snackbar: false,
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
      this.snackbar = true;
      this.loading = false;
    },
  },
};
</script>
