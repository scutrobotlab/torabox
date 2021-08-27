<template>
  <v-list two-line>
    <v-list-item
      v-for="application in applications"
      :key="application.id"
      :to="`/dashboard/application/consumable/${application.id}`"
    >
      <v-list-item-content>
        <v-list-item-title v-text="application.applicant.name"></v-list-item-title>
        <v-list-item-subtitle>
          {{ "申请 " + application.number + " " + application.consumable.name }}
        </v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-list-item-action-text v-if="application.status == 1" class="green--text">
          <v-icon small color="success">mdi-check-circle-outline</v-icon> 已同意
        </v-list-item-action-text>
        <v-list-item-action-text v-else-if="application.status == -1" class="red--text">
          <v-icon small color="error">mdi-close-circle-outline</v-icon> 已拒绝
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
  props: ["applications"],
};
</script>

<style></style>
