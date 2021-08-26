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
          <v-toolbar-title v-if="immovable_application">
            {{ immovable_application.immovable.name }}
          </v-toolbar-title>
        </v-toolbar>

        <v-list>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                {{ "申请 " + (immovable_application.action == "lend" ? "借出" : "还回") }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                申请人：{{ immovable_application.applicant.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                审核人：{{ immovable_application.approver.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-textarea
              :disabled="immovable_application.status != 0"
              label="描述"
              v-model="immovable_application.description"
            ></v-textarea>
          </v-list-item>
          <v-card-actions v-if="access && immovable_application.status == 0">
            <v-spacer />
            <v-btn
              class="mr-3"
              color="primary"
              :loading="updating"
              :disabled="updating"
              v-if="access"
              dark
              @click="updateImmovableApplication(1)"
            >
              同意
            </v-btn>
            <v-btn
              color="error"
              :loading="updating"
              :disabled="updating"
              v-if="access"
              dark
              @click="updateImmovableApplication(-1)"
            >
              拒绝
            </v-btn>
          </v-card-actions>
          <v-list-item v-else-if="immovable_application.status == 1" class="green--text">
            <v-icon large color="success">mdi-check-circle-outline</v-icon> 已同意
          </v-list-item>
          <v-list-item v-else-if="immovable_application.status == -1" class="red--text">
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
  getImmovableApplicationIndex,
  getImmovableApplicationIndexEdit,
  putImmovableApplication,
} from "@/api/immovable_application.js";

export default {
  mixins: [errorMixin],
  components: {
    WaitProgress,
  },
  data: () => ({
    loading: true,
    updating: false,
    access: false,
    immovable_application: null,
  }),
  created() {
    this.loading = true;
    Promise.all([this.checkAccess(), this.getImmovableApplication()]).finally(() => {
      this.loading = false;
    });
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
        getImmovableApplicationIndexEdit(this.$route.params.id)
      );
    },
    async getImmovableApplication() {
      this.immovable_application = await this.errorHandler(
        getImmovableApplicationIndex(this.$route.params.id)
      );
    },
    async updateImmovableApplication(status) {
      this.updating = true;
      await this.errorHandler(
        putImmovableApplication(this.$route.params.id, {
          status,
          description: this.immovable_application.description,
        })
      );
      await this.getImmovableApplication();
      this.updating = false;
    },
  },
};
</script>

<style></style>
