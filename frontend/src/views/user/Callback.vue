<template>
  <v-main>
    <ErrorAlert critical v-model="error" />
    <v-container class="fill-height" fluid>
      <WaitProgress />
    </v-container>
  </v-main>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { postUserSelfSession } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
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
