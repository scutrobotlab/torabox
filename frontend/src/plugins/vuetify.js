import Vue from "vue";
import Vuetify from "vuetify/lib/framework";
import colors from "vuetify/lib/util/colors";

Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: colors.orange.lighten2,
        secondary: colors.blue.lighten1,
        accent: colors.pink.accent2,
      },
      dark: {
        primary: colors.purple.lighten1,
        secondary: colors.cyan.lighten1,
        accent: colors.teal.accent2,
      },
    },
  },
});
