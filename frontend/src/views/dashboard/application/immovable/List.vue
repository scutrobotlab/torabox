<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <WaitProgress v-if="loading" class="ma-7" />

    <v-fade-transition>
      <ApplicationList :applications="applications" v-if="!loading" />
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ApplicationList from "@/components/immovable/ApplicationList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getImmovableApplications } from "@/api/immovable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationList,
  },
  data: () => ({
    loading: true,
    applications: null,
  }),
  async created() {
    this.applications = await this.errorHandler(getImmovableApplications());
    this.loading = false;
  },
};
</script>

<style></style>
