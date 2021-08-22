<template>
  <v-container>
    <v-card flat>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="$router.push('/dashboard/consumable/' + $route.params.id)">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        <v-toolbar-title v-if="consumable">{{ consumable.name }}购买记录</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>

      <v-card-text>
        <v-container>
          <ErrorAlert v-model="error" />
          <WaitProgress v-if="loading" class="ma-7" />
          <v-list v-else two-line>
            <v-subheader>剩余：{{ consumable.number }}</v-subheader>
            <v-list-item v-for="purchase in consumable.purchases" :key="purchase.id">
              <v-list-item-content>
                <v-list-item-title v-text="purchase.user.name"></v-list-item-title>
                <v-list-item-subtitle>
                  {{ "购买数量：" + purchase.number }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-container>
      </v-card-text>
    </v-card>
    <v-btn
      class="mb-7 mr-3"
      color="secondary"
      dark
      absolute
      bottom
      right
      fab
      @click="$refs.ConsumablePurchaseDialog.openDialog()"
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
    <ConsumablePurchaseDialog
      ref="ConsumablePurchaseDialog"
      @getConsumablePurchases="getConsumablePurchases"
    />
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ConsumablePurchaseDialog from "@/components/ConsumablePurchaseDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getConsumableIndexPurchases } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ConsumablePurchaseDialog,
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
