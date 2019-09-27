window.Admin.vue.stores['checks_contest_products'] = new Vuex.Store({
  state: {
    emptyProduct: {
      model: {
        name: '',
        quantity: 0,
        price: 0,
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
  },
});
