<template>
  <v-dialog v-model="dialog" transition="dialog-bottom-transition">
    <v-card>
      <v-toolbar dark>
        <v-spacer />
        <v-btn icon dark @click="dialog = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-row class="fill-height" align-content="center" justify="center">
        <canvas ref="qrcode" class="qrcode" />
      </v-row>
    </v-card>
  </v-dialog>
</template>

<script>
import QRCode from "qrcode";

export default {
  props: ["qrcodeContent"],
  data: () => ({
    dialog: false,
  }),
  methods: {
    showQrcode() {
      this.dialog = true;
      this.$nextTick(() => {
        const qrcodeCanvas = this.$refs.qrcode;
        QRCode.toCanvas(qrcodeCanvas, this.qrcodeContent, {
          width: 300,
        });
      });
    },
  },
};
</script>

<style></style>
