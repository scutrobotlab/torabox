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
import ApplicationList from "@/components/consumable/ApplicationList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import {
  getConsumableApplications,
  getConsumableApplicationPaginationLength,
} from "@/api/consumable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationList,
  },
  data: () => ({
    length: 0,
    loading: true,
    applications: null,
  }),
  computed: {
    page: {
      get() {
        return Number(this.$route.query.p) || 1;
      },
      set(value) {
        this.$router.replace({
          query: {
            ...this.$route.query,
            p: value,
          },
        });
      },
    },
  },
  watch: {
    async page() {
      await this.getApplications();
    },
  },
  async created() {
    this.length = await this.errorHandler(getConsumableApplicationPaginationLength());
    await this.getApplications();
  },
  methods: {
    async getApplications() {
      this.loading = true;
      this.applications = await this.errorHandler(getConsumableApplications(this.page));
      this.loading = false;
    },
  },
};
</script>

<style></style>
