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
              v-for="consumable in item.data"
              :key="consumable.id"
              :to="`/dashboard/consumable/${consumable.id}`"
            >
              <v-list-item-content>
                <v-list-item-title v-text="consumable.name"></v-list-item-title>
                <v-list-item-subtitle>
                  {{ "剩余数量：" + consumable.number }}
                </v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <v-icon>mdi-chevron-right</v-icon>
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
    <v-btn
      class="mb-7 mr-3"
      color="secondary"
      dark
      absolute
      bottom
      right
      fab
      to="/dashboard/consumable/new"
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumables } from "@/api/consumable.js";

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
    this.items[0].data = await this.errorHandler(getConsumables());
    this.loading = false;
  },
};
</script>

<style></style>
