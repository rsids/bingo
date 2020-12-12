<template>
  <div :class="{ isPlayed: track.played }">
    <span v-if="track" :title="trackTitle">{{ track.id }}</span>
  </div>
</template>

<script>
export default {
  name: "BingoTrack",
  props: ["track"],

  computed: {
    trackTitle() {
      return `${this.track.artist} - ${this.track.song}`;
    },
  },
};
</script>

<style scoped>
div {
  align-items: center;
  justify-content: center;
  display: flex;
  height: 100%;
  width: 100%;
}

.isPlayed {
  background: #54db73;
}
</style>
