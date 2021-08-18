<template>
  <v-app id="inspire" class="background">
    <router-view />
    <v-footer app class="blur">
      <v-spacer></v-spacer>
      <div>&copy; 2000-{{ new Date().getFullYear() }}</div>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  mounted() {
    this.$vuetify.theme.dark = window.matchMedia("(prefers-color-scheme: dark)").matches;
  },
};
</script>

<style scoped>
.background.theme--light {
  background-color: #e8e8e8;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 1000'%3E%3Cg %3E%3Ccircle fill='%23E8E8E8' cx='50' cy='0' r='50'/%3E%3Cg fill='%23e6e2e7' %3E%3Ccircle cx='0' cy='50' r='50'/%3E%3Ccircle cx='100' cy='50' r='50'/%3E%3C/g%3E%3Ccircle fill='%23e4dbe5' cx='50' cy='100' r='50'/%3E%3Cg fill='%23e2d5e3' %3E%3Ccircle cx='0' cy='150' r='50'/%3E%3Ccircle cx='100' cy='150' r='50'/%3E%3C/g%3E%3Ccircle fill='%23e0cfe2' cx='50' cy='200' r='50'/%3E%3Cg fill='%23dec8e0' %3E%3Ccircle cx='0' cy='250' r='50'/%3E%3Ccircle cx='100' cy='250' r='50'/%3E%3C/g%3E%3Ccircle fill='%23dcc2df' cx='50' cy='300' r='50'/%3E%3Cg fill='%23dabcdd' %3E%3Ccircle cx='0' cy='350' r='50'/%3E%3Ccircle cx='100' cy='350' r='50'/%3E%3C/g%3E%3Ccircle fill='%23d8b5dc' cx='50' cy='400' r='50'/%3E%3Cg fill='%23d6afda' %3E%3Ccircle cx='0' cy='450' r='50'/%3E%3Ccircle cx='100' cy='450' r='50'/%3E%3C/g%3E%3Ccircle fill='%23d3a9d9' cx='50' cy='500' r='50'/%3E%3Cg fill='%23d1a2d7' %3E%3Ccircle cx='0' cy='550' r='50'/%3E%3Ccircle cx='100' cy='550' r='50'/%3E%3C/g%3E%3Ccircle fill='%23cf9cd5' cx='50' cy='600' r='50'/%3E%3Cg fill='%23cc96d4' %3E%3Ccircle cx='0' cy='650' r='50'/%3E%3Ccircle cx='100' cy='650' r='50'/%3E%3C/g%3E%3Ccircle fill='%23ca8fd2' cx='50' cy='700' r='50'/%3E%3Cg fill='%23c789d0' %3E%3Ccircle cx='0' cy='750' r='50'/%3E%3Ccircle cx='100' cy='750' r='50'/%3E%3C/g%3E%3Ccircle fill='%23c582cf' cx='50' cy='800' r='50'/%3E%3Cg fill='%23c27ccd' %3E%3Ccircle cx='0' cy='850' r='50'/%3E%3Ccircle cx='100' cy='850' r='50'/%3E%3C/g%3E%3Ccircle fill='%23bf75cb' cx='50' cy='900' r='50'/%3E%3Cg fill='%23bd6fca' %3E%3Ccircle cx='0' cy='950' r='50'/%3E%3Ccircle cx='100' cy='950' r='50'/%3E%3C/g%3E%3Ccircle fill='%23BA68C8' cx='50' cy='1000' r='50'/%3E%3C/g%3E%3C/svg%3E");
  background-attachment: fixed;
  background-size: contain;
}
.background.theme--dark {
  background-color: #dd00ff;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 1000'%3E%3Cg %3E%3Ccircle fill='%23DD00FF' cx='50' cy='0' r='50'/%3E%3Cg fill='%23d303f6' %3E%3Ccircle cx='0' cy='50' r='50'/%3E%3Ccircle cx='100' cy='50' r='50'/%3E%3C/g%3E%3Ccircle fill='%23c905ee' cx='50' cy='100' r='50'/%3E%3Cg fill='%23c007e5' %3E%3Ccircle cx='0' cy='150' r='50'/%3E%3Ccircle cx='100' cy='150' r='50'/%3E%3C/g%3E%3Ccircle fill='%23b608dc' cx='50' cy='200' r='50'/%3E%3Cg fill='%23ad09d4' %3E%3Ccircle cx='0' cy='250' r='50'/%3E%3Ccircle cx='100' cy='250' r='50'/%3E%3C/g%3E%3Ccircle fill='%23a309cb' cx='50' cy='300' r='50'/%3E%3Cg fill='%239a09c3' %3E%3Ccircle cx='0' cy='350' r='50'/%3E%3Ccircle cx='100' cy='350' r='50'/%3E%3C/g%3E%3Ccircle fill='%239109ba' cx='50' cy='400' r='50'/%3E%3Cg fill='%238909b1' %3E%3Ccircle cx='0' cy='450' r='50'/%3E%3Ccircle cx='100' cy='450' r='50'/%3E%3C/g%3E%3Ccircle fill='%238008a9' cx='50' cy='500' r='50'/%3E%3Cg fill='%237707a0' %3E%3Ccircle cx='0' cy='550' r='50'/%3E%3Ccircle cx='100' cy='550' r='50'/%3E%3C/g%3E%3Ccircle fill='%236f0798' cx='50' cy='600' r='50'/%3E%3Cg fill='%2367068f' %3E%3Ccircle cx='0' cy='650' r='50'/%3E%3Ccircle cx='100' cy='650' r='50'/%3E%3C/g%3E%3Ccircle fill='%235f0587' cx='50' cy='700' r='50'/%3E%3Cg fill='%2357047e' %3E%3Ccircle cx='0' cy='750' r='50'/%3E%3Ccircle cx='100' cy='750' r='50'/%3E%3C/g%3E%3Ccircle fill='%23500376' cx='50' cy='800' r='50'/%3E%3Cg fill='%2348026e' %3E%3Ccircle cx='0' cy='850' r='50'/%3E%3Ccircle cx='100' cy='850' r='50'/%3E%3C/g%3E%3Ccircle fill='%23410165' cx='50' cy='900' r='50'/%3E%3Cg fill='%233a015d' %3E%3Ccircle cx='0' cy='950' r='50'/%3E%3Ccircle cx='100' cy='950' r='50'/%3E%3C/g%3E%3Ccircle fill='%23330055' cx='50' cy='1000' r='50'/%3E%3C/g%3E%3C/svg%3E");
  background-attachment: fixed;
  background-size: contain;
}
</style>
