import Vue from 'vue';
import {products} from './package/receipts_contest_products';

require('./stores/receipts_contest_products');

Vue.component(
    'ReceiptsContestProductsList',
    require('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsList.vue').default,
);
Vue.component(
    'ReceiptsContestProductsListItem',
    require('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsListItem.vue').default,
);
Vue.component(
    'ReceiptsContestProductsListItemForm',
    require('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsListItemForm.vue').default,
);

products.init();
