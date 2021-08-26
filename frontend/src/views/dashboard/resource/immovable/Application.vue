<template>
  <v-container>
    <ErrorAlert v-model="error" />

    <v-toolbar v-if="!loading">
      <v-btn icon @click="$router.push('/dashboard/resource/immovable/' + $route.params.id)">
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{ immovable.status_text }}</v-toolbar-title>
    </v-toolbar>

    <WaitProgress v-if="loading" class="ma-7" />

    <v-fade-transition>
      <v-list v-if="!loading">
        <v-list-item
          v-for="application in immovable.applications"
          :key="application.id"
          :to="`/dashboard/application/immovable/${application.id}`"
        >
          <v-list-item-content>
            <v-list-item-title v-text="application.applicant.name"></v-list-item-title>
            <v-list-item-subtitle>
              申请 {{ application.action == "lend" ? "借出" : "还回" }}
            </v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-action>
            <v-list-item-action-text v-if="application.status == 1" class="green--text">
              <v-icon small color="success">mdi-check-circle-outline</v-icon> 已同意
            </v-list-item-action-text>
            <v-list-item-action-text v-else-if="application.status == -1" class="red--text">
              <v-icon small color="error">mdi-close-circle-outline</v-icon> 已拒绝
            </v-list-item-action-text>
          </v-list-item-action>
          <v-list-item-action>
            <v-icon>mdi-chevron-right</v-icon>
          </v-list-item-action>
        </v-list-item>
      </v-list>
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getImmovableIndexApplications } from "@/api/immovable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
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
