<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <WaitProgress v-if="loading" class="ma-7" />
    <v-tabs v-else v-model="tab" align-with-title>
      <v-tabs-slider color="secondary"></v-tabs-slider>
      <v-tab v-for="(item, i) in items" :key="i">
        {{ item.text }}
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab">
      <v-tab-item v-for="(item, i) in items" :key="i">
        <v-card flat>
          <v-list two-line>
            <v-list-item
              v-for="application in item.data"
              :key="application.id"
              :to="`/dashboard/application/consumable/${application.id}`"
            >
              <v-list-item-content>
                <v-list-item-title v-text="application.applicant.name"></v-list-item-title>
                <v-list-item-subtitle>
                  {{ "申请 " + application.number + " " + application.consumable.name }}
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
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableApplications } from "@/api/consumable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  data: () => ({
    loading: true,
    tab: null,
    items: [
      { text: "全部", data: null },
      // TODO
      { text: "组内", data: null },
      { text: "我的", data: null },
    ],
  }),
  async created() {
    this.items[0].data = await this.errorHandler(getConsumableApplications());
    this.loading = false;
  },
};
</script>

<style></style>
