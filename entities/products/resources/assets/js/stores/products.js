window.Admin.vue.stores['products'] = new Vuex.Store({
  state: {
    emptyProduct: {
      model: {
        name: '',
        product_id: '',
        confirmed: [],
        date_start: '',
        date_end: ''
      },
      errors: {},
      isModified: false,
      hash: '',
    },
    product: {},
    productsIds: [],
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
    addProductId(state, productId) {
      state.productsIds.push(productId);
    },
    removeProductId(state, productId) {
      state.productsIds = _.remove(state.productsIds, function(stateProductId) {
        return stateProductId !== productId;
      });
    },
    setMode(state, mode) {
      state.mode = mode;
    },
  },
});
