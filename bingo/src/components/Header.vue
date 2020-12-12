<template>
  <v-app-bar app color="primary" dark>
    <div class="d-flex align-center">
      <h1>Disco Bingo</h1>
    </div>
    <v-spacer></v-spacer>
    <v-btn to="/" text>
      <v-icon>mdi-music</v-icon>
      <span class="ml-2">Rondes</span>
    </v-btn>

    <v-btn to="/users" text>
      <v-icon>mdi-account</v-icon>
      <span class="ml-2">Deelnemers</span>
    </v-btn>
    <template v-slot:extension v-if="tabs.length > 0">
      <v-tabs v-model="selectedTab" align-with-title>
        <v-tabs-slider color="yellow"></v-tabs-slider>

        <v-tab v-for="item in tabs" :key="item">
          {{ item }}
        </v-tab>
      </v-tabs>
    </template>
  </v-app-bar>
</template>

<script>
import { mapMutations, mapState } from "vuex";

export default {
  name: "BingoHeader",
  mounted() {},
  methods: {
    ...mapMutations("ui", ["setTab"]),
  },
  computed: {
    ...mapState("ui", ["tabs", "tab"]),

    selectedTab: {
      get() {
        return this.tab;
      },

      set(val) {
        this.setTab(val);
      },
    },
  },
};
</script>
