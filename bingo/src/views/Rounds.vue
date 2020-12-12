<template>
  <div>
    <h2>Rondes</h2>
    <v-list-item
      v-for="round of rounds"
      :key="round.id"
      :to="{ name: 'round', params: { id: round.id } }"
    >
      <v-list-item-content>
        <v-list-item-title>{{ round.attributes.title }}</v-list-item-title>
      </v-list-item-content>
      <v-list-item-action>
        <v-icon @click.prevent="onDeleteRound(round)">mdi-delete</v-icon>
      </v-list-item-action>
    </v-list-item>
    <v-btn color="secondary" @click="setShowNewRound(true)"
      >Nieuwe ronde
    </v-btn>
    <bingo-create-round></bingo-create-round>
  </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
import BingoCreateRound from "@/components/CreateRound";
export default {
  name: "Rounds",
  components: { BingoCreateRound },
  mounted() {
    this.getRounds().then((d) => {
      console.log(d);
    });
  },

  computed: {
    ...mapState(["rounds"]),
    ...mapState("ui", ["showNewRound"]),
  },

  methods: {
    ...mapActions(["getRounds", "createRound", "deleteRound"]),
    ...mapMutations("ui", ["setShowNewRound"]),

    async addRound() {
      let res = await this.$dialog.prompt({
        text: "Naam van de ronde",
        title: "Naam van de ronde",
      });
      this.createRound({ round: res });
    },

    onDeleteRound(round) {
      this.deleteRound(round);
    },
  },
};
</script>

<style scoped></style>
