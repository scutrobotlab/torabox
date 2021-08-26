<template>
  <v-container>
    <v-fade-transition>
      <v-list two-line v-if="!loading">
        <v-list-item
          v-for="consumable in consumables"
          :key="consumable.id"
          :to="`/dashboard/resource/consumable/${consumable.id}`"
        >
          <v-list-item-content>
            <v-list-item-title v-text="consumable.name"></v-list-item-title>
            <v-list-item-subtitle> 剩余数量： {{ consumable.number }} </v-list-item-subtitle>
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
import NewDialog from "@/components/consumable/NewDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  components: {
    NewDialog,
  },
  computed: {
    consumables() {
      return this.$store.state.consumables;
    },
  },
  data: () => ({
    loading: true,
  }),
  async created() {
    await this.$store.dispatch("getConsumables");
  },
  mounted() {
    this.loading = false;
  },
};
</script>

<style></style>
