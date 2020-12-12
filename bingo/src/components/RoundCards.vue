<template>
  <div class="cards">
    <bingo-card
      v-for="card of cards"
      v-bind:key="card.id"
      :card="card"
    ></bingo-card>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import BingoCard from "@/components/Card";

export default {
  name: "BingoRoundCards",
  components: { BingoCard },
  mounted() {
    this.getCards(this.round);
  },

  computed: {
    ...mapState(["round", "cards"]),
  },
  methods: {
    ...mapActions(["getCards"]),
  },
};
</script>

<style scoped>
.cards {
  display: flex;
  flex-wrap: wrap;
}
</style>
