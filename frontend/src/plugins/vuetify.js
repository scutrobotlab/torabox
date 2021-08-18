import Vue from "vue";
import Vuetify from "vuetify/lib/framework";
import colors from "vuetify/lib/util/colors";

Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: colors.purple.lighten1,
        secondary: colors.pink.lighten1,
        accent: colors.deepPurple.accent1,
      },
      dark: {
        primary: colors.purple.darken3,
        secondary: colors.pink.darken3,
        accent: colors.deepPurple.accent3,
      },
    },
  },
});
