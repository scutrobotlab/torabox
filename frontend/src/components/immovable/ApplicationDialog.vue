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
            <v-form v-else ref="form" v-model="valid" lazy-validation :disabled="saving">
              <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-select
                    v-if="immovable.need_approval"
                    :items="immovable.approvers"
                    item-text="name"
                    item-value="id"
                    v-model="immovable_application.approver_id"
                    label="审批人*"
                  ></v-select>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                    label="描述"
                    v-model="immovable_application.description"
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
import WaitProgress from "@/components/WaitProgress.vue";
import { getImmovableIndexApprovers } from "@/api/immovable.js";
import { postImmovableApplication } from "@/api/immovable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  data: () => ({
    loading: true,
    dialog: false,
    saving: false,
    valid: true,
    immovable: {
      approvers: null,
    },
    immovable_application: {
      immovable_id: null,
      approver_id: null,
      action: null,
      description: null,
    },
  }),
  methods: {
    async openDialog() {
      this.immovable = await this.errorHandler(getImmovableIndexApprovers(this.$route.params.id));
      this.loading = false;
      this.dialog = true;
    },
    async save() {
      this.saving = true;
      this.immovable_application.immovable_id = this.$route.params.id;
      await this.errorHandler(postImmovableApplication(this.immovable_application));
      this.$emit("getImmovable");
      this.saving = false;
      this.dialog = false;
    },
  },
};
</script>
