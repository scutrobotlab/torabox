<template>
  <v-container>
    <v-fade-transition>
      <ListItem :consumables="consumables" v-if="!loading" />
    </v-fade-transition>

    <NewDialog />
  </v-container>
</template>

<script>
import ListItem from "@/components/consumable/ListItem.vue";
import NewDialog from "@/components/consumable/NewDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  components: {
    NewDialog,
    ListItem,
  },
  computed: {
    consumables() {
      return this.$store.state.consumables;
    },
  },
  data: () => ({
    loading: true,
  }),
  created() {
    this.$store.dispatch("getConsumables");
  },
  mounted() {
    this.loading = false;
  },
};
</script>

<style></style>
