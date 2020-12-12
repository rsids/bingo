<template>
  <v-card v-if="round" elevation="2" shaped max-width="1000">
    <v-card-title
      ><span
        >Ronde <span>{{ round.attributes.title }}</span></span
      ></v-card-title
    >

    <bingo-round-tracks v-if="tab === 0"></bingo-round-tracks>
    <bingo-round-cards v-if="tab === 1"></bingo-round-cards>
  </v-card>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import BingoRoundTracks from "@/components/RoundTracks";
import BingoRoundCards from "@/components/RoundCards";
export default {
  name: "Rounds",
  components: { BingoRoundCards, BingoRoundTracks },
  mounted() {
    this.getRound({ id: this.$route.params.id });
    this.setTabs(["tracks", "cards"]);
  },
  destroyed() {
    this.setTabs([]);
  },

  computed: {
    ...mapState(["round"]),
    ...mapState("ui", ["tab"]),
  },

  methods: {
    ...mapActions(["getRound"]),
    ...mapMutations("ui", ["setTabs"]),
  },
};
</script>

<style scoped></style>
