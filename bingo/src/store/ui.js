const ui = {
  namespaced: true,
  state: {
    showNewRound: false,
    showImportUsers: false,
    showSendCards: false,
    tab: "",
    tabs: [],
  },
  mutations: {
    setShowNewRound(state, show) {
      state.showNewRound = show;
    },
    setShowImportUsers(state, show) {
      state.showImportUsers = show;
    },
    setShowSendCards(state, show) {
      state.showSendCards = show;
    },
    setTabs(state, tabs) {
      state.tabs = tabs;
      state.tab = 0;
    },
    setTab(state, tab) {
      state.tab = tab;
    },
  },
};

export default ui;
