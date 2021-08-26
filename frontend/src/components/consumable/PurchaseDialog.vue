<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-toolbar dark dense color="primary">
          <v-toolbar-title>新增购买</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <ErrorAlert v-model="error" />
            <v-form ref="form" v-model="valid" lazy-validation :disabled="saving">
              <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-text-field
                    label="购买数量*"
                    type="number"
                    :rules="[
                      (v) => !!v || '购买数量是必要的',
                      (v) => Number.isInteger(v) || '购买数量应为整数',
                      (v) => v > 0 || '购买数量应为正数',
                    ]"
                    v-model.number="consumable_purchase.number"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                    label="描述"
                    v-model="consumable_purchase.description"
                    required
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            block
            :loading="saving"
            :disabled="!valid || saving"
            @click="save()"
          >
            确定
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import { postConsumablePurchase } from "@/api/consumable_purchase.js";

export default {
  mixins: [errorMixin],
  data: () => ({
    dialog: false,
    saving: false,
    valid: true,
    consumable: {},
    consumable_purchase: {
      consumable_id: null,
      number: null,
      description: null,
    },
  }),
  methods: {
    openDialog() {
      this.dialog = true;
    },
    async save() {
      this.saving = true;
      this.consumable_purchase.consumable_id = this.$route.params.id;
      await this.errorHandler(postConsumablePurchase(this.consumable_purchase));
      this.$emit("getConsumable");
      this.saving = false;
      this.dialog = false;
    },
  },
};
</script>
