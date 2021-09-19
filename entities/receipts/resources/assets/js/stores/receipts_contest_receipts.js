import hash from 'object-hash';

window.Admin.vue.stores['receipts_contest_receipts'] = new window.Vuex.Store({
  state: {
    receipt: {
      model: {},
      errors: {},
      hash: ''
    },
    receipts: [],
    mode: '',
  },
  mutations: {
    setReceipt(state, receipt) {
      let receiptCopy = JSON.parse(JSON.stringify(receipt));

      state.receipt.model = receiptCopy;
      state.receipt.hash = hash(receiptCopy);
    },
    setReceipts(state, receipts) {
      state.receipts = receipts;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
    reset(state) {
      state.mode = '';
      state.receipt = {
        model: {},
        errors: {},
        hash: ''
      };
      state.receipts = [];
    }
  }
});
