<template>
  <v-row class="fill-height" align="center" justify="center">
    <ErrorAlert v-model="error" />
    <v-progress-circular :size="70" :width="7" color="primary" indeterminate></v-progress-circular>
  </v-row>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { getUserSelfSession } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  async created() {
    const success = await this.errorHandler(getUserSelfSession());
    if (success) {
      this.$router.push("/dashboard/main");
    } else {
      this.$router.push("/user/login");
    }
  },
};
</script>
