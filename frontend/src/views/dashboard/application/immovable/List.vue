<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <WaitProgress v-if="loading" class="ma-7" />

    <v-fade-transition>
      <ApplicationList :applications="applications" v-if="!loading" />
    </v-fade-transition>
    <div class="text-center">
      <v-pagination v-model="page" :length="length"></v-pagination>
    </div>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ApplicationList from "@/components/immovable/ApplicationList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import {
  getImmovableApplications,
  getImmovableApplicationPaginationLength,
} from "@/api/immovable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationList,
  },
  data: () => ({
    page: 1,
    length: 0,
    loading: true,
    applications: null,
  }),
  watch: {
    async page() {
      await this.getApplications();
    },
  },
  async created() {
    this.length = await this.errorHandler(getImmovableApplicationPaginationLength());
    await this.getApplications();
  },
  methods: {
    async getApplications() {
      this.loading = true;
      this.applications = await this.errorHandler(getImmovableApplications(this.page));
      this.loading = false;
    },
  },
};
</script>

<style></style>
