<template>
  <v-container>
    <WaitProgress v-if="loading" class="ma-7" />
    <v-fade-transition>
      <v-card v-if="!loading">
        <v-toolbar dense>
          <v-btn icon @click="$router.go(-1)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-toolbar-title></v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <ErrorAlert v-model="error" />
        <ListItem :immovables="immovables" />
      </v-card>
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import ListItem from "@/components/immovable/ListItem.vue";
import errorMixin from "@/mixins/errorMixin.js";
import { getUserSelfImmovablesOwned } from "@/api/user.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
    ListItem,
  },
  data: () => ({
    loading: true,
    immovables: null,
  }),
  async created() {
    this.immovables = await this.errorHandler(getUserSelfImmovablesOwned());
    this.loading = false;
  },
};
</script>

<style></style>
