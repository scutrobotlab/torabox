<template>
  <v-container>
    <v-tabs v-model="tab" align-with-title>
      <v-tabs-slider color="secondary"></v-tabs-slider>
      <v-tab v-for="(item, i) in items" :key="i">
        {{ item.text }}
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab">
      <v-tab-item v-for="(item, i) in items" :key="i">
        <v-card flat>
          <v-list two-line>
            <v-list-item v-for="subscription in item.data" :key="subscription.id">
              <v-list-item-content>
                <v-list-item-title v-text="subscription.name"></v-list-item-title>
                <v-list-item-subtitle>{{
                  "到期时间：" + subscription.end_time
                }}</v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <v-btn icon @click="$router.push('/dashboard/subscription/' + subscription.id)">
                  <v-icon>mdi-information</v-icon>
                </v-btn>
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
    <v-btn color="primary" dark absolute bottom right fab to="/dashboard/subscription/new">
      <v-icon>mdi-plus</v-icon>
    </v-btn>
  </v-container>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { getSubscriptions } from "@/api/subscription.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    tab: null,
    items: [
      { text: "全部", data: null },
      // TODO
      { text: "组内", data: null },
      { text: "我的", data: null },
    ],
  }),
  async created() {
    this.items[0].data = await this.errorHandler(getSubscriptions());
  },
};
</script>

<style></style>
