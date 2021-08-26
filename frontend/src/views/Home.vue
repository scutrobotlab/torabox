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
import { getUserSelfSession } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  async created() {
    const success = await this.errorHandler(getUserSelfSession());
    if (success) {
      this.$router.push("/dashboard/resource");
    } else {
      this.$router.push("/user/login");
    }
  },
};
</script>
