<template>
  <v-list>
    <v-list-item v-for="purchase in purchases" :key="purchase.id">
      <v-list-item-content>
        <v-list-item-title>
          {{ purchase.user.name }} 购买 {{ purchase.number }} 个
        </v-list-item-title>
        <v-list-item-subtitle>购买于{{ fromNow(purchase.created_at) }}</v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon v-bind="attrs" v-on="on"> mdi-information-outline</v-icon>
          </template>
          <span>{{ purchase.description }}</span>
        </v-tooltip>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>

<script>
import { fromNow } from "@/utils/moment";
export default {
  props: ["purchases"],
  methods: {
    fromNow,
  },
};
</script>

<style></style>
