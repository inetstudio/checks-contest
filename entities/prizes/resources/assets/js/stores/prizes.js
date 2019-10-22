window.Admin.vue.stores['checks_contest_prizes'] = new Vuex.Store({
  state: {
    emptyPrize: {
      model: {
        name: '',
        prize_id: '',
        confirmed: [],
        date_start: '',
        date_end: ''
      },
      errors: {},
      isModified: false,
      hash: '',
    },
    prize: {},
    prizesIds: [],
    mode: '',
  },
  mutations: {
    setPrize(state, prize) {
      let emptyPrize = JSON.parse(JSON.stringify(state.emptyPrize));
      emptyPrize.model.id = UUID.generate();

      let resultPrize = _.merge(emptyPrize, prize);
      resultPrize.hash = window.hash(resultPrize.model);

      state.prize = resultPrize;
    },
    addPrizeId(state, prizeId) {
      state.prizesIds.push(prizeId);
    },
    removePrizeId(state, prizeId) {
      state.prizesIds = _.remove(state.prizesIds, function(statePrizeId) {
        return statePrizeId !== prizeId;
      });
    },
    setMode(state, mode) {
      state.mode = mode;
    },
    reset(state) {
      state.mode = '';
      state.prize = {};
      state.prizesIds = [];
    }
  },
});
