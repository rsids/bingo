import Vue from "vue";
import Vuetify from "vuetify";

import "vuetify/dist/vuetify.min.css";
Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: "#2f165f",
        secondary: "#cddc39",
        accent: "#ffeb3b",
        error: "#ff5722",
        warning: "#ffc107",
        info: "#00bcd4",
        success: "#4caf50",
      },
    },
  },
});
