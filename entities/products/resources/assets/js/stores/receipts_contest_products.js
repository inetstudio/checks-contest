import hash from 'object-hash';
import { v4 as uuidv4 } from 'uuid';

window.Admin.vue.stores['receipts_contest_products'] = new window.Vuex.Store({
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
      state.product.hash = hash(state.product.model);
    },
    newProduct(state, receiptId) {
      let productId = uuidv4();

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
