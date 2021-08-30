<template>
  <v-container>
    <ErrorAlert v-model="error" />

    <v-toolbar v-if="!loading">
      <v-btn icon @click="$router.go(-1)">
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{ immovable.status_text }}</v-toolbar-title>
    </v-toolbar>

    <WaitProgress v-if="loading" class="ma-7" />

    <v-fade-transition>
      <ApplicationList :applications="immovable.applications" v-if="!loading" />
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ApplicationList from "@/components/immovable/ApplicationList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getImmovableIndexApplications } from "@/api/immovable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationList,
  },
  data: () => ({
    loading: true,
    immovable: {
      number: null,
      applications: [],
      approvers: [],
    },
  }),
  async created() {
    await this.getImmovableApplications();
  },
  methods: {
    async getImmovableApplications() {
      this.loading = true;
      this.immovable = await this.errorHandler(
        getImmovableIndexApplications(this.$route.params.id)
      );
      this.loading = false;
    },
  },
};
</script>

<style></style>
