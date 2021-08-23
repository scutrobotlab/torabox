<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <WaitProgress v-if="loading" class="ma-7" />
    <v-list v-else>
      <v-list-item>
        <v-list-item-action @click="$router.push('/dashboard/consumable/' + $route.params.id)">
          <v-icon>mdi-chevron-left</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            {{ consumable.name }}申请记录 剩余：{{ consumable.number }}
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item
        v-for="application in consumable.applications"
        :key="application.id"
        :to="`/dashboard/application/consumable/${application.id}`"
      >
        <v-list-item-content>
          <v-list-item-title v-text="application.applicant.name"></v-list-item-title>
          <v-list-item-subtitle>
            {{ "申请数量：" + application.number }}
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

    <v-btn
      v-if="consumable.number"
      class="mb-15 mr-3"
      color="secondary"
      fixed
      dark
      absolute
      bottom
      right
      fab
      @click="$refs.ConsumableApplicationDialog.openDialog()"
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
    <ConsumableApplicationDialog
      ref="ConsumableApplicationDialog"
      @getConsumableApplications="getConsumableApplications"
    />
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ConsumableApplicationDialog from "@/components/ConsumableApplicationDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableIndexApplications } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ConsumableApplicationDialog,
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
