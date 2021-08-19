<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <v-card>
      <v-card-text>
        <UserProfileList :user="user" />
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import UserProfileList from "@/components/UserProfileList.vue";
import errorMixin from "@/mixins/errorMixin.js";

export default {
  mixins: [errorMixin],
  components: {
    UserProfileList,
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
};
</script>
