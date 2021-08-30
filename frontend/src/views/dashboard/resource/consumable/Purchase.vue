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
      <PurchaseList :purchases="consumable.purchases" v-if="!loading" />
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import PurchaseList from "@/components/consumable/PurchaseList.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableIndexPurchases } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    PurchaseList,
  },
  data: () => ({
    loading: true,
    consumable: {
      purchases: [],
    },
  }),
  async created() {
    await this.getConsumablePurchases();
  },
  methods: {
    async getConsumablePurchases() {
      this.loading = true;
      this.consumable = await this.errorHandler(getConsumableIndexPurchases(this.$route.params.id));
      this.loading = false;
    },
  },
};
</script>

<style></style>
