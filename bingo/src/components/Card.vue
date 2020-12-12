<template>
  <v-card
    elevation="4"
    class="ma-4"
    shaped
    tile
    max-width="200"
    v-if="trackList"
  >
    <table class="bingo-table">
      <tr class="bingo-table__row bingo-table__row--header">
        <th>B</th>
        <th>i</th>
        <th>n</th>
        <th>g</th>
        <th>o</th>
      </tr>

      <tr class="bingo-table__row" v-for="(_, row) in 5" :key="row">
        <td v-for="(_, col) in 5" :key="col">
          <v-icon v-if="col === 2 && row === 2">mdi-album</v-icon>
          <bingo-track v-else :track="trackList[col + row * 5]"></bingo-track>
        </td>
      </tr>
    </table>
    <div class="text-right text-caption">{{ card.id }}</div>
  </v-card>
</template>

<script>
import BingoTrack from "@/components/Track";
export default {
  name: "BingoCard",
  components: { BingoTrack },
  props: ["card"],
  data() {
    return {
      trackList: [],
    };
  },

  watch: {
    card: {
      immediate: true,
      handler(val) {
        this.trackList = [
          ...val.attributes.tracks.slice(0, 12),
          "",
          ...val.attributes.tracks.slice(13),
        ];
      },
    },
  },
};
</script>

<style scoped lang="scss">
.bingo-table {
  --bingo-red: #f50000;
  table-layout: fixed;
  text-transform: uppercase;
  border-collapse: collapse;
  td,
  th {
    border: 2px solid var(--bingo-red);
    height: 40px;
    width: 40px;
    text-align: center;
    vertical-align: center;
  }
  th {
    background: var(--bingo-red);
    color: white;
  }
}
</style>
