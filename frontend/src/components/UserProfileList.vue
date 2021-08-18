<template>
  <v-list dense v-if="user">
    <v-list-item>
      <v-list-item-icon>
        <v-icon>mdi-account</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title v-text="user.name"></v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-icon>
        <v-icon>mdi-email</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title v-text="user.email"></v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item v-for="(group, i) in user.groups" :key="i">
      <v-list-item-icon>
        <v-icon>mdi-information</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{
          group.name + (group.pivot.power == 2 ? "组长" : "组员")
        }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: ["user"],
};
</script>

<style></style>
