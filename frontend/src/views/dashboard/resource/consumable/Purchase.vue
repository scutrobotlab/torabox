<template>
  <v-container>
    <ErrorAlert v-model="error" />

    <v-toolbar v-if="!loading">
      <v-btn icon @click="$router.push('/dashboard/resource/consumable/' + $route.params.id)">
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-toolbar-title> {{ consumable.name }} 剩余：{{ consumable.number }} </v-toolbar-title>
    </v-toolbar>

    <WaitProgress v-if="loading" class="ma-7" />

    <v-fade-transition>
      <v-list v-if="!loading">
        <v-list-item v-for="purchase in consumable.purchases" :key="purchase.id">
          <v-list-item-content>
            <v-list-item-title v-text="purchase.user.name"></v-list-item-title>
            <v-list-item-subtitle>
              {{ "购买数量：" + purchase.number }}
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableIndexPurchases } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
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
