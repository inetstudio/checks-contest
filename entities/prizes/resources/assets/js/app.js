import Vue from 'vue';
import {prizes} from './package/receipts_contest_prizes';

require('./stores/receipts_contest_prizes');

Vue.component(
    'ReceiptsContestPrizesList',
    require('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesList.vue').default,
);
Vue.component(
    'ReceiptsContestPrizesListItem',
    require('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesListItem.vue').default,
);
Vue.component(
    'ReceiptsContestPrizesListItemForm',
    require('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesListItemForm.vue').default,
);

prizes.init();
