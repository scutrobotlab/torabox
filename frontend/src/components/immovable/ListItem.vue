<template>
  <v-list two-line>
    <slot></slot>
    <v-list-item
      v-for="immovable in immovables"
      :key="immovable.id"
      :to="`/dashboard/resource/immovable/${immovable.id}`"
    >
      <v-list-item-content>
        <v-list-item-title>{{ immovable.name }}</v-list-item-title>
        <v-list-item-subtitle>负责人： {{ immovable.user.name }}</v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-list-item-action-text v-if="immovable.status == 0" class="green--text">
          <v-icon small color="success">mdi-check-circle-outline</v-icon>
          {{ immovable.status_text }}
        </v-list-item-action-text>
        <v-list-item-action-text v-else-if="immovable.status == -1" class="red--text">
          <v-icon small color="error">mdi-close-circle-outline</v-icon> {{ immovable.status_text }}
        </v-list-item-action-text>
        <v-list-item-action-text v-else-if="immovable.status == 1" class="accent--text">
          <v-icon small color="accent">mdi-alert-circle-outline</v-icon> {{ immovable.status_text }}
        </v-list-item-action-text>
      </v-list-item-action>
      <v-list-item-action>
        <v-icon>mdi-chevron-right</v-icon>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: ["immovables"],
};
</script>

<style></style>
