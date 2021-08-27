<template>
  <v-container>
    <v-fade-transition>
      <v-card v-show="show">
        <v-toolbar dense>
          <v-btn icon @click="$router.go(-1)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-toolbar-title></v-toolbar-title>
          <v-spacer></v-spacer>
          <v-switch
            class="mt-5"
            v-model="switcher"
            @click="getApplications"
            label="仅显示待处理"
          ></v-switch>
        </v-toolbar>
        <ErrorAlert v-model="error" />
        <WaitProgress v-if="loading" class="ma-7" />
        <ApplicationList :applications="applications" v-if="!loading" />
      </v-card>
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ApplicationList from "@/components/consumable/ApplicationList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getUserSelfConsumableApplicationsApplied } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ApplicationList,
  },
  data: () => ({
    switcher: true,
    show: false,
    loading: true,
    applications: null,
  }),
  async created() {
    await this.getApplications();
    this.show = true;
  },
  methods: {
    async getApplications() {
      this.loading = true;
      this.applications = await this.errorHandler(
        getUserSelfConsumableApplicationsApplied(Number(this.switcher))
      );
      this.loading = false;
    },
  },
};
</script>

<style></style>
