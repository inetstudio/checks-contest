import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

window.Admin.vue.stores['receipts_contest_products'] = new Vuex.Store({
  state: {
    product: {
      model: {},
      errors: {},
      hash: '',
    },
    products: [],
    mode: '',
  },
  mutations: {
    setProduct(state, product) {
      let productCopy = JSON.parse(JSON.stringify(product));

      state.product.model = (productCopy.hasOwnProperty('model')) ? productCopy.model : productCopy;
      state.product.hash = window.hash(state.product.model);
    },
    newProduct(state, receiptId) {
      let productId = UUID.generate();

      let product = {
        id: productId,
        receipt_id: receiptId,
        fns_receipt_id: null
      };

      this.commit('setProduct', product);
    },
    setProducts(state, products) {
      state.products = products;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
    reset(state) {
      state.mode = '';
      state.product = {
        model: {},
        errors: {},
        hash: ''
      };
      state.products = [];
    }
  }
});
