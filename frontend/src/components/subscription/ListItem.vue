<template>
  <v-list two-line>
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
</template>

<script>
export default {
  props: ["subscriptions"],
};
</script>

<style></style>
