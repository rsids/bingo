<template>
  <div>
    <v-card
      v-for="group of userGroups"
      elevation="2"
      v-bind:key="group.title"
      shaped
      class="mb-8"
      max-width="900"
    >
      <v-card-title
        ><span
          >Groep <span>{{ group.title }}</span></span
        ></v-card-title
      >
      <v-card-text>
        <v-list-item v-for="user of group.users" :key="user.id" three-line>
          <v-list-item-content>
            <v-list-item-title>{{ user.attributes.name }}</v-list-item-title>
            <v-list-item-subtitle>{{
              user.attributes.email
            }}</v-list-item-subtitle>
            <v-list-item-subtitle v-if="user.attributes.track"
              ><span>{{ user.attributes.track.artist }}</span>
              <span> - </span>
              <span>{{ user.attributes.track.song }}</span>
            </v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-action>
            <v-icon
              @click.prevent="onSelectSong(user)"
              title="Kies favoriete nummer"
              >mdi-heart</v-icon
            >
          </v-list-item-action>
          <v-list-item-action>
            <v-icon @click.prevent="onDeleteUser(user)">mdi-delete</v-icon>
          </v-list-item-action>
        </v-list-item>
      </v-card-text>
      <v-card-actions>
        <v-btn text @click="onSendCards(group.title)">
          <v-icon>mdi-apps-box</v-icon>
          Bingokaarten versturen
        </v-btn>
      </v-card-actions>
    </v-card>

    <v-btn color="secondary" @click="setShowImportUsers(true)"
      >Deelnemers importeren
    </v-btn>
    <bingo-import-users></bingo-import-users>
    <bingo-send-cards :group="activeGroup"></bingo-send-cards>
    <bingo-track-selector v-if="user" :user="user"></bingo-track-selector>
  </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
import BingoImportUsers from "@/components/ImportUsers";
import BingoSendCards from "@/components/SendCards";
import BingoTrackSelector from "@/components/TrackSelector";
export default {
  name: "Users",
  data() {
    return {
      userGroups: [],
      user: null,
      activeGroup: null,
    };
  },
  components: { BingoTrackSelector, BingoSendCards, BingoImportUsers },
  mounted() {
    this.getUsers();
  },

  computed: {
    ...mapState(["users"]),
  },

  methods: {
    ...mapActions(["getUsers", "deleteUser"]),
    ...mapMutations("ui", [
      "setShowImportUsers",
      "setShowSendCards",
      "setShowSelectTrack",
    ]),

    async onDeleteUser(user) {
      let res = await this.$dialog.confirm({
        title: "Zeker weten?",
        text: `Weet je zeker dat ${user.attributes.name} niet meer mee doet?`,
      });
      if (res) {
        this.deleteUser(user);
      }
    },

    onSelectSong(user) {
      this.user = user;
      this.setShowSelectTrack(true);
    },

    onSendCards(group) {
      this.setShowSendCards(true);
      this.activeGroup = group;
    },
  },

  watch: {
    users: function (usrs) {
      this.userGroups = createUserGroups(usrs);
    },
  },
};

function createUserGroups(usrs) {
  const userGroups = {};
  usrs.forEach((user) => {
    if (!userGroups[user.attributes.group]) {
      userGroups[user.attributes.group] = {
        title: user.attributes.group,
        users: [],
      };
    }
    userGroups[user.attributes.group].users.push(user);
  });
  return Object.keys(userGroups).map((k) => userGroups[k]);
}
</script>

<style scoped></style>
