<template>
  <v-container>
    <ErrorAlert v-model="error" />
    <WaitProgress v-if="loading" class="ma-7" />
    <v-fade-transition>
      <v-card v-if="!loading">
        <v-toolbar>
          <v-btn icon @click="$router.go(-1)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-toolbar-title v-if="consumable_application">
            {{ consumable_application.consumable.name }}
          </v-toolbar-title>
        </v-toolbar>

        <v-list>
          <v-list-item v-if="consumable_application.status == 0">
            <v-list-item-content>
              <v-list-item-title>
                剩余数量：{{ consumable_application.consumable.number }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>申请数量：{{ consumable_application.number }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                申请人：{{ consumable_application.applicant.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item v-if="consumable_application.consumable.need_approval">
            <v-list-item-content>
              <v-list-item-title>
                审核人：{{ consumable_application.approver.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-textarea
              :disabled="consumable_application.status != 0"
              label="描述"
              v-model="consumable_application.description"
            ></v-textarea>
          </v-list-item>
          <v-card-actions v-if="access && consumable_application.status == 0">
            <v-spacer />
            <v-btn
              class="mr-3"
              color="primary"
              :loading="updating"
              :disabled="updating"
              v-if="access"
              @click="updateConsumableApplication(1)"
            >
              同意
            </v-btn>
            <v-btn
              color="error"
              :loading="updating"
              :disabled="updating"
              v-if="access"
              @click="updateConsumableApplication(-1)"
            >
              拒绝
            </v-btn>
          </v-card-actions>
          <v-list-item v-else-if="consumable_application.status == 1" class="green--text">
            <v-icon large color="success">mdi-check-circle-outline</v-icon> 已同意
          </v-list-item>
          <v-list-item v-else-if="consumable_application.status == -1" class="red--text">
            <v-icon large color="error">mdi-close-circle-outline</v-icon> 已拒绝
          </v-list-item>
        </v-list>
      </v-card>
    </v-fade-transition>
  </v-container>
</template>

<script>
import WaitProgress from "@/components/WaitProgress.vue";
import errorMixin from "@/mixins/errorMixin.js";
import {
  getConsumableApplicationIndex,
  getConsumableApplicationIndexEdit,
  putConsumableApplication,
} from "@/api/consumable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  data: () => ({
    loading: true,
    updating: false,
    access: false,
    consumable_application: null,
  }),
  created() {
    this.loading = true;
    this.errorHandler(Promise.all([this.checkAccess(), this.getConsumableApplication()])).finally(
      () => {
        this.loading = false;
      }
    );
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    groups() {
      return this.$store.state.groups;
    },
  },
  methods: {
    async checkAccess() {
      this.access = await this.errorHandler(
        getConsumableApplicationIndexEdit(this.$route.params.id)
      );
    },
    async getConsumableApplication() {
      this.consumable_application = await this.errorHandler(
        getConsumableApplicationIndex(this.$route.params.id)
      );
    },
    async updateConsumableApplication(status) {
      this.updating = true;
      this.errorHandler(
        putConsumableApplication(this.$route.params.id, {
          status,
          description: this.consumable_application.description,
        })
      )
        .then(async () => {
          await this.getConsumableApplication();
        })
        .finally(() => {
          this.updating = false;
        });
    },
  },
};
</script>

<style></style>
