import {receipts} from './package/receipts_contest_receipts';

require('./stores/receipts_contest_receipts');

window.Vue.component(
    'ReceiptsContestReceiptForm',
    () => import('./components/pages/Form.vue'),
);

receipts.init();
