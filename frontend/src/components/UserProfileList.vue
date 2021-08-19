<template>
  <v-list dense v-if="user">
    <v-list-item two-line>
      <v-list-item-avatar tile>
        <v-img :src="user.avatar" />
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title>{{ user.name }}</v-list-item-title>
        <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
    <v-list-group no-action prepend-icon="mdi-information">
      <template v-slot:activator>
        <v-list-item-content>
          <v-list-item-title>身份</v-list-item-title>
        </v-list-item-content>
      </template>
      <v-list-item v-for="(group, i) in user.groups" :key="i">
        <v-list-item-content>
          <v-list-item-title>{{
            group.name + (group.pivot.power == 2 || group.pivot.privilege == 2 ? "组长" : "组员")
          }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-group>
  </v-list>
</template>

<script>
export default {
  props: ["user"],
};
</script>

<style></style>
