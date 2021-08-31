<template>
  <v-list two-line>
    <slot></slot>
    <v-list-item
      v-for="immovable_kind in immovable_kinds"
      :key="immovable_kind.id"
      :to="`/dashboard/resource/immovable_kind/${immovable_kind.id}`"
    >
      <v-list-item-content>
        <v-list-item-title>{{ immovable_kind.name }}</v-list-item-title>
        <v-list-item-subtitle>归属： {{ immovable_kind.group.name }}</v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-icon>mdi-chevron-right</v-icon>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: ["immovable_kinds"],
};
</script>

<style></style>
