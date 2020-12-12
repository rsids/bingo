<template>
  <v-app>
    <bingo-header></bingo-header>

    <v-main>
      <v-container class="px-6" fluid>
        <v-row>
          <v-col cols="12">
            <router-view />
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import BingoHeader from "@/components/Header";

export default {
  name: "App",

  components: {
    BingoHeader,
  },

  data: () => ({
    //
  }),
};
</script>
<style>
:root {
  --tsx: 1px;
  --tsy: 1px;
  --tsb: 1px;
}
@font-face {
  font-style: normal;
  font-weight: normal;
  font-family: "street_credregular";
  src: url("assets/street-cred-webfont.woff2") format("woff2"),
    url("assets/street-cred-webfont.woff") format("woff");
}

h1 {
  font-family: "street_credregular";
  font-size: 48px;
  font-weight: normal;
  color: #fa1900;
  text-shadow: var(--tsx) var(--tsy) var(--tsb) yellow;
  transition: text-shadow 0.2s ease;
}
</style>
