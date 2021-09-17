import {products} from './package/receipts_contest_products';

require('./stores/receipts_contest_products');

window.Vue.component(
    'ReceiptsContestProductsList',
    require('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsList.vue').default,
);
window.Vue.component(
    'ReceiptsContestProductsListItem',
    require('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsListItem.vue').default,
);
window.Vue.component(
    'ReceiptsContestProductsListItemForm',
    require('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsListItemForm.vue').default,
);

products.init();
