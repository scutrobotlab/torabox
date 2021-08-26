<template>
  <v-list two-line>
    <slot></slot>
    <v-list-item
      v-for="consumable in consumables"
      :key="consumable.id"
      :to="`/dashboard/resource/consumable/${consumable.id}`"
    >
      <v-list-item-content>
        <v-list-item-title v-text="consumable.name"></v-list-item-title>
        <v-list-item-subtitle> 剩余数量： {{ consumable.number }} </v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-icon>mdi-chevron-right</v-icon>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: ["consumables"],
};
</script>

<style></style>
