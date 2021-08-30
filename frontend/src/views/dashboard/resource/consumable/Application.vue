<template>
  <v-container>
    <ErrorAlert v-model="error" />

    <v-toolbar v-if="!loading">
      <v-btn icon @click="$router.go(-1)">
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-toolbar-title> {{ consumable.name }} 剩余：{{ consumable.number }} </v-toolbar-title>
    </v-toolbar>

    <WaitProgress v-if="loading" class="ma-7" />

    <v-fade-transition>
      <ApplicationList :applications="consumable.applications" v-if="!loading" />
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ApplicationList from "@/components/consumable/ApplicationList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableIndexApplications } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationList,
  },
  data: () => ({
    loading: true,
    consumable: {
      number: null,
      applications: [],
      approvers: [],
    },
  }),
  async created() {
    await this.getConsumableApplications();
  },
  methods: {
    async getConsumableApplications() {
      this.loading = true;
      this.consumable = await this.errorHandler(
        getConsumableIndexApplications(this.$route.params.id)
      );
      this.loading = false;
    },
  },
};
</script>

<style></style>
