<template>
  <v-container>
    <v-card>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="$router.push('/dashboard/consumable')">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <ErrorAlert v-model="error" />
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="名称*"
                  type="text"
                  :rules="[(v) => !!v || '名称是必要的']"
                  v-model="consumable.name"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="[
                    { id: 1, name: '是' },
                    { id: 0, name: '否' },
                  ]"
                  item-text="name"
                  item-value="id"
                  v-model="consumable.need_approval"
                  label="审批需求*"
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col v-if="user.groups" cols="12" sm="6" md="6">
                <v-select
                  :items="user.groups"
                  item-text="name"
                  item-value="id"
                  :rules="[(v) => !!v || '归属是必要的']"
                  v-model="consumable.group_id"
                  label="归属*"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="负责人*"
                  type="text"
                  disabled
                  :value="user.name"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="12" md="12">
                <v-textarea label="描述" v-model="consumable.description" required></v-textarea>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
        <v-card-actions>
          <v-btn color="primary" block dark @click="save">保存</v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { postConsumable } from "@/api/consumable.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    valid: true,
    consumable: {
      id: null,
      name: null,
      need_approval: null,
      user: null,
      group_id: null,
      description: null,
    },
  }),
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    async save() {
      await this.errorHandler(postConsumable(this.consumable));
      this.$router.push("/dashboard/consumable");
    },
  },
};
</script>

<style></style>
