<template>
  <v-list two-line>
    <v-list-item
      v-for="application in applications"
      :key="application.id"
      :to="`/dashboard/application/consumable/${application.id}`"
    >
      <v-list-item-content>
        <v-list-item-title>
          {{ application.applicant.name }} 申请 {{ application.number }}
          {{ application.consumable == null ? "个" : application.consumable.name }}
        </v-list-item-title>
        <v-list-item-subtitle>申请于{{ fromNow(application.created_at) }} </v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-list-item-action-text v-if="application.status == 1" class="green--text">
          <v-icon small color="success">mdi-check-circle-outline</v-icon> 已同意
        </v-list-item-action-text>
        <v-list-item-action-text v-else-if="application.status == -1" class="red--text">
          <v-icon small color="error">mdi-close-circle-outline</v-icon> 已拒绝
        </v-list-item-action-text>
        <v-list-item-action-text v-else class="accent--text">
          <v-icon small color="accent">mdi-alert-circle-outline</v-icon> 待审核
        </v-list-item-action-text>
      </v-list-item-action>
      <v-list-item-action>
        <v-icon>mdi-chevron-right</v-icon>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>

<script>
import { fromNow } from "@/utils/moment";
export default {
  props: ["applications"],
  methods: {
    fromNow,
  },
};
</script>

<style></style>
