<template>
  <v-container>
    <v-card flat>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="$router.push('/dashboard/consumable/' + $route.params.id)">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        <v-toolbar-title v-if="consumable">{{ consumable.name }}申请记录</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>

      <v-card-text>
        <v-container>
          <ErrorAlert v-model="error" />
          <WaitProgress v-if="loading" class="ma-7" />
          <v-list v-else two-line>
            <v-subheader>剩余：{{ consumable.number }}</v-subheader>
            <v-list-item v-for="application in consumable.applications" :key="application.id">
              <v-list-item-content>
                <v-list-item-title v-text="application.applicant.name"></v-list-item-title>
                <v-list-item-subtitle>
                  {{ "申请数量：" + application.number }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-container>
      </v-card-text>
    </v-card>
    <v-btn
      v-if="consumable.number"
      class="mb-7 mr-3"
      color="secondary"
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
