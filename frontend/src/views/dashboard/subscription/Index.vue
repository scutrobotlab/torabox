<template>
  <v-container>
    <SubscriptionCard :subscription-id="$route.params.id" />
  </v-container>
</template>

<script>
import SubscriptionCard from "@/components/SubscriptionCard.vue";
export default {
  components: {
    SubscriptionCard,
  },
};
</script>

<style></style>
