<template>
  <v-list two-line>
    <slot></slot>
    <v-list-item
      v-for="immovable in immovables"
      :key="immovable.id"
      :to="`/dashboard/resource/immovable/${immovable.id}`"
    >
      <v-list-item-content>
        <v-list-item-title v-text="immovable.name"></v-list-item-title>
        <v-list-item-subtitle>{{ immovable.status_text }}</v-list-item-subtitle>
      </v-list-item-content>
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
