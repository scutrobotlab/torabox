<template>
  <v-container>
    <v-fade-transition>
      <v-card>
        <v-toolbar dense>
          <v-text-field
            v-model="keyword"
            hide-details
            prepend-icon="mdi-magnify"
            single-line
          ></v-text-field>
          <v-spacer></v-spacer>
          <v-menu :close-on-content-click="false" offset-y transition="slide-y-transition">
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
            <v-list dense>
              <v-list-item>
                <v-switch v-model="showImmovable" label="不动产"></v-switch>
              </v-list-item>
              <v-list-item>
                <v-switch v-model="showConsumable" label="消耗品"></v-switch>
              </v-list-item>
              <v-list-item>
                <v-switch v-model="showSubscription" label="订阅类"></v-switch>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-toolbar>

        <ListImmovable :immovables="searchImmovables" v-if="showImmovable">
          <v-subheader>不动产</v-subheader>
        </ListImmovable>
        <v-divider></v-divider>
        <ListConsumable :consumables="searchConsumables" v-if="showConsumable">
          <v-subheader>消耗品</v-subheader>
        </ListConsumable>
        <v-divider></v-divider>
        <ListSubscription :subscriptions="searchSubscriptions" v-if="showSubscription">
          <v-subheader>订阅类</v-subheader>
        </ListSubscription>
      </v-card>
    </v-fade-transition>
  </v-container>
</template>

<script>
import ListImmovable from "@/components/immovable/ListItem.vue";
import ListConsumable from "@/components/consumable/ListItem.vue";
import ListSubscription from "@/components/subscription/ListItem.vue";

export default {
  components: {
    ListImmovable,
    ListConsumable,
    ListSubscription,
  },
  data: () => ({
    keyword: "",
    showImmovable: true,
    showConsumable: true,
    showSubscription: true,
  }),
  computed: {
    searchImmovables() {
      return this.$store.getters.searchImmovables(this.keyword).slice(0, 100);
    },
    searchConsumables() {
      return this.$store.getters.searchConsumables(this.keyword).slice(0, 100);
    },
    searchSubscriptions() {
      return this.$store.getters.searchSubscriptions(this.keyword).slice(0, 100);
    },
  },
  async created() {
    Promise.all([
      this.$store.dispatch("getImmovables"),
      this.$store.dispatch("getConsumables"),
      this.$store.dispatch("getSubscriptions"),
    ]);
  },
};
</script>

<style></style>
