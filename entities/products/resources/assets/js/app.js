require('./stores/products');

Vue.component(
    'ProductsList',
    require('./components/partials/ProductsList/ProductsList.vue').default,
);
Vue.component(
    'ProductsListItem',
    require('./components/partials/ProductsList/ProductsListItem.vue').default,
);
Vue.component(
    'ProductsListItemForm',
    require('./components/partials/ProductsList/ProductsListItemForm.vue').default,
);

let products = require('./package/products');
products.init();
