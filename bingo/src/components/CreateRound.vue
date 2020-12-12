<template>
  <v-dialog width="500" v-model="visible">
    <v-card>
      <v-card-title class="headline"> Nieuwe ronde </v-card-title>

      <v-card-text>
        <v-text-field
          label="Naam van de ronde*"
          required
          v-model="title"
        ></v-text-field>

        <v-file-input
          @change="updatePlaylist"
          ref="playlist"
          label="Playlist"
          accept=".csv"
          truncate-length="15"
        ></v-file-input>
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
import parser from "csv-parse";
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  name: "BingoCreateRound",
  data: () => {
    return {
      active: true,
      tracks: [],
      title: "",
    };
  },

  computed: {
    ...mapState("ui", ["showNewRound"]),
    isDisabled() {
      return this.title.trim() === "" || this.tracks.length === 0;
    },

    visible: {
      get() {
        return this.showNewRound;
      },

      set(value) {
        this.setShowNewRound(value);
      },
    },
  },

  methods: {
    ...mapActions(["createRound"]),
    ...mapMutations("ui", ["setShowNewRound"]),
    async updatePlaylist(playlist) {
      const csv = await playlist.text();
      parser(csv, { columns: true, delimiter: "," }, (err, output) => {
        this.tracks = output.map((track) => {
          return {
            artist: track["Artist Name"],
            song: track["Track Name"],
          };
        });
      });
    },
    onSave() {
      if (this.title.trim() !== "" && this.tracks.length > 0) {
        this.createRound({ title: this.title, tracks: this.tracks }).then(() =>
          this.setShowNewRound(false)
        );
      }
    },
  },
};
</script>

<style scoped></style>
