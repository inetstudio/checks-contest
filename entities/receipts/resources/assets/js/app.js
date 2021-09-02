import Vue from 'vue';
import {receipts} from './package/receipts_contest_receipts';

require('./stores/receipts_contest_receipts');

Vue.component(
    'ReceiptsContestReceiptForm',
    require('./components/pages/Form.vue').default,
);

receipts.init();
