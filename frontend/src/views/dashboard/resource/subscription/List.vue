<template>
  <v-container>
    <v-fade-transition>
      <ListItem :subscriptions="subscriptions" v-if="!loading" />
    </v-fade-transition>

    <NewDialog />
  </v-container>
</template>

<script>
import ListItem from "@/components/subscription/ListItem.vue";
import NewDialog from "@/components/subscription/NewDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  components: {
    ListItem,
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
  created() {
    this.$store.dispatch("getSubscriptions");
  },
  mounted() {
    this.loading = false;
  },
};
</script>

<style></style>
