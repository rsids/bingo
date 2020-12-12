<template>
  <v-list flat v-if="round">
    <v-list-item v-for="track of round.attributes.tracks" :key="track.id">
      <v-list-item-action>
        <v-checkbox
          :input-value="track.played"
          @change="updateTrack($event, track)"
        ></v-checkbox>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title
          ><div>{{ track.artist }} - {{ track.song }}</div></v-list-item-title
        >
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
  name: "BingoRoundTracks",

  computed: {
    ...mapState(["round"]),
  },

  methods: {
    ...mapActions(["setPlayed"]),

    updateTrack($event, track) {
      track.played = $event;
      this.setPlayed({ id: track.id, played: $event });
    },
  },
};
</script>

<style scoped></style>
