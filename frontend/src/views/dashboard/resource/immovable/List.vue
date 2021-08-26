<template>
  <v-container>
    <v-fade-transition>
      <ListItem :immovables="immovables" v-if="!loading" />
    </v-fade-transition>

    <v-fab-transition>
      <v-speed-dial
        v-show="!loading"
        class="mb-7 mr-3"
        v-model="fab"
        bottom
        right
        fixed
        dark
        transition="slide-y-reverse-transition"
      >
        <template v-slot:activator>
          <v-btn v-model="fab" color="secondary" dark fab>
            <v-icon v-if="fab"> mdi-close </v-icon>
            <v-icon v-else> mdi-plus </v-icon>
          </v-btn>
        </template>

        <v-btn fab dark small color="green" @click="$refs.NewKindDialog.openDialog()">
          <v-icon>mdi-tag-plus</v-icon>
        </v-btn>
        <v-btn fab dark small color="indigo" @click="$refs.NewDialog.openDialog()">
          <v-icon>mdi-toy-brick-plus</v-icon>
        </v-btn>
      </v-speed-dial>
    </v-fab-transition>
    <NewKindDialog ref="NewKindDialog" />
    <NewDialog ref="NewDialog" />
  </v-container>
</template>

<script>
import ListItem from "@/components/immovable/ListItem.vue";
import NewKindDialog from "@/components/immovable/NewKindDialog.vue";
import NewDialog from "@/components/immovable/NewDialog.vue";
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  components: {
    ListItem,
    NewKindDialog,
    NewDialog,
  },
  computed: {
    immovables() {
      return this.$store.state.immovables;
    },
  },
  data: () => ({
    fab: false,
    loading: true,
  }),
  async created() {
    Promise.all([this.$store.dispatch("getImmovables"), this.$store.dispatch("getKinds")]);
  },
  mounted() {
    this.loading = false;
  },
};
</script>

<style></style>
