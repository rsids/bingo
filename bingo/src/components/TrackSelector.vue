<template>
  <v-dialog width="500" v-model="visible">
    <v-card>
      <v-card-title class="headline"><span>Kies een track</span></v-card-title>

      <v-card-text>
        <v-autocomplete
          v-model="track"
          item-text="attributes.track"
          item-value="id"
          :items="tracks"
        ></v-autocomplete>
      </v-card-text>
      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" text @click="onSave" :disabled="isDisabled">
          Opslaan
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  name: "BingoTrackSelector",
  props: ["user"],
  data: () => {
    return {
      title: "",
      text: "",
      track: null,
      selectedRounds: [],
    };
  },

  mounted() {
    if (this.tracks.length === 0) {
      this.getTracks();
    }
  },

  computed: {
    ...mapState("ui", ["showSelectTrack"]),
    ...mapState(["tracks"]),
    isDisabled() {
      return this.track === null;
    },

    visible: {
      get() {
        return this.showSelectTrack;
      },

      set(value) {
        this.setShowSelectTrack(value);
      },
    },
  },

  methods: {
    ...mapActions(["getTracks", "setFavoriteTrack"]),
    ...mapMutations("ui", ["setShowSelectTrack"]),

    onSave() {
      this.setFavoriteTrack({ userId: this.user.id, trackId: this.track }).then(
        () => {
          this.$dialog.notify.success("Favoriet opgeslagen");
          this.user.attributes.track = {
            ...this.tracks.find((t) => t.id === this.track).attributes,
          };
          this.setShowSelectTrack(false);
        }
      );
    },
  },
};
</script>

<style scoped></style>
