<template>
  <v-dialog width="500" v-model="visible">
    <v-card>
      <v-card-title class="headline"> Deelnemers importeren </v-card-title>

      <v-card-text>
        <v-text-field
          label="Naam van de groep*"
          required
          v-model="title"
        ></v-text-field>

        <v-file-input
          @change="updateUsers"
          label="Deelnemers"
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
  name: "BingoImportUsers",
  data: () => {
    return {
      users: [],
      title: "",
    };
  },

  computed: {
    ...mapState("ui", ["showImportUsers"]),
    isDisabled() {
      return this.title.trim() === "" || this.users.length === 0;
    },

    visible: {
      get() {
        return this.showImportUsers;
      },

      set(value) {
        this.setShowImportUsers(value);
      },
    },
  },

  methods: {
    ...mapActions(["importUsers"]),
    ...mapMutations("ui", ["setShowImportUsers"]),
    async updateUsers(playlist) {
      const csv = await playlist.text();
      parser(csv, { columns: true, delimiter: "," }, (err, output) => {
        this.users = output.map((user) => {
          return {
            name: user["Je naam"],
            email: user["Je (prive) e-mailadres"],
          };
        });
      });
    },
    onSave() {
      if (this.title.trim() !== "" && this.users.length > 0) {
        this.importUsers({ group: this.title, users: this.users }).then(() =>
          this.setShowImportUsers(false)
        );
      }
    },
  },
};
</script>

<style scoped></style>
