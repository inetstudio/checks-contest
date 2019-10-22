window.Admin.vue.stores['checks_contest_products'] = new Vuex.Store({
  state: {
    emptyProduct: {
      model: {
        fns_receipt_id: 0,
        receipt_id: 0,
        name: '',
        quantity: 0,
        price: 0,
        highlight: false,
        product_data: {}
      },
      errors: {},
      isModified: false,
      hash: '',
    },
    product: {},
    mode: '',
  },
  mutations: {
    setProduct(state, product) {
      let emptyProduct = JSON.parse(JSON.stringify(state.emptyProduct));
      emptyProduct.model.id = UUID.generate();

      let resultProduct = _.merge(emptyProduct, product);
      resultProduct.hash = window.hash(resultProduct.model);

      state.product = resultProduct;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
    modifyEmptyProduct(state, product) {
      let emptyProduct = JSON.parse(JSON.stringify(state.emptyProduct));
      emptyProduct.model.fns_receipt_id = product.fns_receipt_id;
      emptyProduct.model.receipt_id = product.receipt_id;

      state.emptyProduct = emptyProduct;
    }
  },
});
