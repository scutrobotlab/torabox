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
  background-color: #e7cca7;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 1000'%3E%3Cg %3E%3Ccircle fill='%23E7CCA7' cx='50' cy='0' r='50'/%3E%3Cg fill='%23e6c8a1' %3E%3Ccircle cx='0' cy='50' r='50'/%3E%3Ccircle cx='100' cy='50' r='50'/%3E%3C/g%3E%3Ccircle fill='%23e5c49b' cx='50' cy='100' r='50'/%3E%3Cg fill='%23e4bf95' %3E%3Ccircle cx='0' cy='150' r='50'/%3E%3Ccircle cx='100' cy='150' r='50'/%3E%3C/g%3E%3Ccircle fill='%23e3bb8f' cx='50' cy='200' r='50'/%3E%3Cg fill='%23e2b689' %3E%3Ccircle cx='0' cy='250' r='50'/%3E%3Ccircle cx='100' cy='250' r='50'/%3E%3C/g%3E%3Ccircle fill='%23e1b283' cx='50' cy='300' r='50'/%3E%3Cg fill='%23e0ad7d' %3E%3Ccircle cx='0' cy='350' r='50'/%3E%3Ccircle cx='100' cy='350' r='50'/%3E%3C/g%3E%3Ccircle fill='%23dfa876' cx='50' cy='400' r='50'/%3E%3Cg fill='%23dea370' %3E%3Ccircle cx='0' cy='450' r='50'/%3E%3Ccircle cx='100' cy='450' r='50'/%3E%3C/g%3E%3Ccircle fill='%23de9d6a' cx='50' cy='500' r='50'/%3E%3Cg fill='%23dd9863' %3E%3Ccircle cx='0' cy='550' r='50'/%3E%3Ccircle cx='100' cy='550' r='50'/%3E%3C/g%3E%3Ccircle fill='%23dc925d' cx='50' cy='600' r='50'/%3E%3Cg fill='%23dc8c57' %3E%3Ccircle cx='0' cy='650' r='50'/%3E%3Ccircle cx='100' cy='650' r='50'/%3E%3C/g%3E%3Ccircle fill='%23db8650' cx='50' cy='700' r='50'/%3E%3Cg fill='%23db8049' %3E%3Ccircle cx='0' cy='750' r='50'/%3E%3Ccircle cx='100' cy='750' r='50'/%3E%3C/g%3E%3Ccircle fill='%23da7a43' cx='50' cy='800' r='50'/%3E%3Cg fill='%23da743c' %3E%3Ccircle cx='0' cy='850' r='50'/%3E%3Ccircle cx='100' cy='850' r='50'/%3E%3C/g%3E%3Ccircle fill='%23da6d36' cx='50' cy='900' r='50'/%3E%3Cg fill='%23d9662f' %3E%3Ccircle cx='0' cy='950' r='50'/%3E%3Ccircle cx='100' cy='950' r='50'/%3E%3C/g%3E%3Ccircle fill='%23D95F28' cx='50' cy='1000' r='50'/%3E%3C/g%3E%3C/svg%3E");
  background-attachment: fixed;
  background-size: contain;
}
.background.theme--dark {
  background-color: #eca9c2;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 1000'%3E%3Cg %3E%3Ccircle fill='%23ECA9C2' cx='50' cy='0' r='50'/%3E%3Cg fill='%23eaa0c0' %3E%3Ccircle cx='0' cy='50' r='50'/%3E%3Ccircle cx='100' cy='50' r='50'/%3E%3C/g%3E%3Ccircle fill='%23e797be' cx='50' cy='100' r='50'/%3E%3Cg fill='%23e48ebd' %3E%3Ccircle cx='0' cy='150' r='50'/%3E%3Ccircle cx='100' cy='150' r='50'/%3E%3C/g%3E%3Ccircle fill='%23e285bd' cx='50' cy='200' r='50'/%3E%3Cg fill='%23df7cbd' %3E%3Ccircle cx='0' cy='250' r='50'/%3E%3Ccircle cx='100' cy='250' r='50'/%3E%3C/g%3E%3Ccircle fill='%23dc74bf' cx='50' cy='300' r='50'/%3E%3Cg fill='%23d96bc0' %3E%3Ccircle cx='0' cy='350' r='50'/%3E%3Ccircle cx='100' cy='350' r='50'/%3E%3C/g%3E%3Ccircle fill='%23d662c3' cx='50' cy='400' r='50'/%3E%3Cg fill='%23d35ac6' %3E%3Ccircle cx='0' cy='450' r='50'/%3E%3Ccircle cx='100' cy='450' r='50'/%3E%3C/g%3E%3Ccircle fill='%23d051c9' cx='50' cy='500' r='50'/%3E%3Cg fill='%23cb49cc' %3E%3Ccircle cx='0' cy='550' r='50'/%3E%3Ccircle cx='100' cy='550' r='50'/%3E%3C/g%3E%3Ccircle fill='%23c041c9' cx='50' cy='600' r='50'/%3E%3Cg fill='%23b439c5' %3E%3Ccircle cx='0' cy='650' r='50'/%3E%3Ccircle cx='100' cy='650' r='50'/%3E%3C/g%3E%3Ccircle fill='%23a337bb' cx='50' cy='700' r='50'/%3E%3Cg fill='%239436b1' %3E%3Ccircle cx='0' cy='750' r='50'/%3E%3Ccircle cx='100' cy='750' r='50'/%3E%3C/g%3E%3Ccircle fill='%238534a8' cx='50' cy='800' r='50'/%3E%3Cg fill='%2378329e' %3E%3Ccircle cx='0' cy='850' r='50'/%3E%3Ccircle cx='100' cy='850' r='50'/%3E%3C/g%3E%3Ccircle fill='%236b2f95' cx='50' cy='900' r='50'/%3E%3Cg fill='%235f2d8b' %3E%3Ccircle cx='0' cy='950' r='50'/%3E%3Ccircle cx='100' cy='950' r='50'/%3E%3C/g%3E%3Ccircle fill='%23542B82' cx='50' cy='1000' r='50'/%3E%3C/g%3E%3C/svg%3E");
  background-attachment: fixed;
  background-size: contain;
}
</style>
