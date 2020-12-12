<template>
  <v-dialog width="500" v-model="visible">
    <v-card>
      <v-card-title class="headline"
        ><span
          >Bingokaarten versturen naar <span>{{ group }}</span></span
        ></v-card-title
      >

      <v-card-text>
        <p>Rondes:</p>
        <v-checkbox
          v-for="round of rounds"
          v-bind:key="round.id"
          v-model="selectedRounds"
          :label="round.attributes.title"
          :value="round.id"
        ></v-checkbox>

        <v-text-field
          label="Onderwerp van e-mail*"
          required
          v-model="title"
        ></v-text-field>

        <v-textarea
          auto-grow
          required
          v-model="text"
          label="Text in e-mail*"
          rows="4"
          row-height="30"
        ></v-textarea>
      </v-card-text>
      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" text @click="onSave" :disabled="isDisabled">
          Verzenden
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  name: "BingoSendCards",
  props: ["group"],
  data: () => {
    return {
      title: "",
      text: "",
      selectedRounds: [],
    };
  },

  mounted() {
    this.getRounds().then(() => {});
  },

  computed: {
    ...mapState("ui", ["showSendCards"]),
    ...mapState(["rounds"]),
    isDisabled() {
      return (
        this.text.trim() === "" ||
        this.title.trim() === "" ||
        this.selectedRounds.length === 0
      );
    },

    visible: {
      get() {
        return this.showSendCards;
      },

      set(value) {
        this.setShowSendCards(value);
      },
    },
  },

  methods: {
    ...mapActions(["sendCards", "getRounds"]),
    ...mapMutations("ui", ["setShowSendCards"]),

    onSave() {
      if (
        this.title.trim() !== "" &&
        this.text.trim() !== "" &&
        this.selectedRounds.length > 0
      ) {
        this.sendCards({
          subject: this.title,
          text: this.text,
          group: this.group,
          rounds: this.selectedRounds,
        }).then(() => {
          this.setShowSendCards(false);
          this.$dialog.notify.success("Emails verzonden!");
        });
      }
    },
  },
};
</script>

<style scoped></style>
