<template>
  <v-main>
    <ErrorAlert critical v-model="error" />
    <v-container class="fill-height" fluid>
      <v-row align="center" justify="center">
        <v-progress-circular indeterminate color="primary"></v-progress-circular>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { postUserSelfSession } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  async created() {
    const user = await this.errorHandler(postUserSelfSession(this.$route.query.code));
    if (user) {
      localStorage.setItem("login", true);
      this.$router.push("/dashboard/main");
    }
  },
};
</script>

<style></style>
