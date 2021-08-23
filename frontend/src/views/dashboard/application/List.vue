<template>
  <v-container>
    <v-card>
      <v-card-text>
        <v-list>
          <v-subheader>相关记录</v-subheader>
          <v-list-item to="/dashboard/application/consumable">
            <v-list-item-content>
              <v-list-item-title>消耗品申请记录</v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-chevron-right</v-icon>
            </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {};
</script>

<style></style>
