import {products} from './package/receipts_contest_products';

require('./stores/receipts_contest_products');

window.Vue.component(
    'ReceiptsContestProductsList',
    () => import('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsList.vue'),
);
window.Vue.component(
    'ReceiptsContestProductsListItem',
    () => import('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsListItem.vue'),
);
window.Vue.component(
    'ReceiptsContestProductsListItemForm',
    () => import('./components/partials/ReceiptsContestProductsList/ReceiptsContestProductsListItemForm.vue'),
);

products.init();
