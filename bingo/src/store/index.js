import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import ui from "./ui";

Vue.use(Vuex);

const base = "http://localhost:7801/api/";

export default new Vuex.Store({
  state: {
    cards: [],
    tracks: [],
    rounds: [],
    round: null,
    users: [],
  },
  mutations: {
    setCards(state, cards) {
      state.cards = cards;
    },
    setRound(state, round) {
      state.round = round;
    },
    setRounds(state, rounds) {
      state.rounds = rounds;
    },
    setTracks(state, tracks) {
      state.tracks = tracks;
    },
    setUsers(state, users) {
      state.users = users;
    },
  },
  actions: {
    createRound({ commit }, data) {
      return axios.post(base + "rounds", data).then((result) => {
        commit("setRounds", result.data.data);
      });
    },

    deleteRound({ commit }, { id }) {
      return axios.delete(base + "rounds/" + id).then((result) => {
        commit("setRounds", result.data.data);
      });
    },

    getCards({ commit }, { id }) {
      return axios.get(base + "cards/round/" + id).then((result) => {
        commit("setCards", result.data.data);
      });
    },

    deleteUser({ commit, state }, { id }) {
      return axios.delete(base + "users/" + id).then((result) => {
        commit("setUsers", result.data.data);
        return state.users;
      });
    },
    getRounds({ commit }) {
      return axios.get(base + "rounds").then((result) => {
        commit("setRounds", result.data.data);
      });
    },
    getRound({ commit }, { id }) {
      return axios.get(base + "rounds/" + id).then((result) => {
        commit("setRound", result.data);
      });
    },
    getTracks() {
      axios.get(base + "?m=getTracks").then((trackData) => {
        console.log(trackData);
      });
    },
    getUsers({ commit, state }) {
      return axios.get(base + "users").then((result) => {
        commit("setUsers", result.data.data);
        return state.users;
      });
    },
    importUsers({ commit, state }, data) {
      return axios.post(base + "users", data).then((result) => {
        commit("setUsers", result.data.data);
        return state.users;
      });
    },

    sendCards(_, data) {
      return axios.post(base + "cards", data);
    },

    setPlayed(_, { id, played }) {
      return axios.put(base + "tracks/" + id, { played });
    },
  },
  modules: {
    ui,
  },
});
