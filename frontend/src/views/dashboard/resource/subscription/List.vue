<template>
  <v-container>
    <v-fade-transition>
      <v-list two-line v-if="!loading">
        <v-list-item
          v-for="subscription in subscriptions"
          :key="subscription.id"
          :to="`/dashboard/resource/subscription/${subscription.id}`"
        >
          <v-list-item-content>
            <v-list-item-title v-text="subscription.name"></v-list-item-title>
            <v-list-item-subtitle>到期时间：{{ subscription.end_time }}</v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-action>
            <v-icon>mdi-chevron-right</v-icon>
          </v-list-item-action>
        </v-list-item>
      </v-list>
    </v-fade-transition>

    <NewDialog />
  </v-container>
</template>

<script>
import NewDialog from "@/components/subscription/NewDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  components: {
    NewDialog,
  },
  computed: {
    subscriptions() {
      return this.$store.state.subscriptions;
    },
  },
  data: () => ({
    loading: true,
  }),
  async created() {
    await this.$store.dispatch("getSubscriptions");
  },
  mounted() {
    this.loading = false;
  },
};
</script>

<style></style>
