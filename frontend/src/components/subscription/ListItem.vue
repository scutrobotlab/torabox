<template>
  <v-list two-line>
    <slot></slot>
    <v-list-item
      v-for="subscription in subscriptions"
      :key="subscription.id"
      :to="`/dashboard/resource/subscription/${subscription.id}`"
    >
      <v-list-item-content>
        <v-list-item-title>{{ subscription.name }}</v-list-item-title>
        <v-list-item-subtitle>负责人： {{ subscription.user.name }}</v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-list-item-action-text>到期时间：{{ subscription.end_time }}</v-list-item-action-text>
      </v-list-item-action>
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
