<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-toolbar dense dark color="primary">
          <v-toolbar-title>新增申请</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <ErrorAlert v-model="error" />
            <WaitProgress v-if="loading" />
            <v-form v-else ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    label="申请数量*"
                    type="number"
                    :hint="`剩余：${consumable.number}`"
                    persistent-hint
                    :rules="[
                      (v) => !!v || '申请数量是必要的',
                      (v) => Number.isInteger(v) || '申请数量应为整数',
                      (v) => v <= consumable.number || '申请数量过多',
                      (v) => v > 0 || '申请数量应为正数',
                    ]"
                    v-model.number="consumable_application.number"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-select
                    v-if="consumable.need_approval"
                    :items="consumable.approvers"
                    item-text="name"
                    item-value="id"
                    v-model="consumable_application.approver_id"
                    label="审批人*"
                  ></v-select>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                    label="描述"
                    v-model="consumable_application.description"
                    required
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" block :disabled="!valid" @click="save()">确定</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import errorMixin from "@/mixins/errorMixin.js";
import WaitProgress from "@/components/WaitProgress.vue";
import { getConsumableIndexApprovers } from "@/api/consumable.js";
import { postConsumableApplication } from "@/api/consumable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  data: () => ({
    loading: true,
    dialog: false,
    valid: true,
    consumable: {
      approvers: null,
    },
    consumable_application: {
      consumable_id: null,
      approver_id: null,
      number: null,
      description: null,
    },
  }),
  methods: {
    async openDialog() {
      this.consumable = await this.errorHandler(getConsumableIndexApprovers(this.$route.params.id));
      this.loading = false;
      this.dialog = true;
    },
    async save() {
      this.consumable_application.consumable_id = this.$route.params.id;
      await this.errorHandler(postConsumableApplication(this.consumable_application));
      this.$emit("getConsumableApplications");
      this.dialog = false;
    },
  },
};
</script>
