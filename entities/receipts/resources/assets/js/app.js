import {receipts} from './package/receipts_contest_receipts';

require('./stores/receipts_contest_receipts');

window.Vue.component(
    'ReceiptsContestReceiptForm',
    require('./components/pages/Form.vue').default,
);

receipts.init();
