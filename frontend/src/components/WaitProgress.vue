<template>
  <v-row class="fill-height" align-content="center" justify="center">
    <v-progress-circular size="70" width="7" indeterminate color="secondary"></v-progress-circular>
    <v-col class="subtitle-1 text-center" cols="12">{{ text }}</v-col>
  </v-row>
</template>

<script>
export default {
  props: ["text"],
};
</script>

<style></style>
