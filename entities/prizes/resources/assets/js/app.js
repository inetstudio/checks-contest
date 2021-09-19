import {prizes} from './package/receipts_contest_prizes';

require('./stores/receipts_contest_prizes');

window.Vue.component(
    'ReceiptsContestPrizesList',
    () => import('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesList.vue'),
);
window.Vue.component(
    'ReceiptsContestPrizesListItem',
    () => import('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesListItem.vue'),
);
window.Vue.component(
    'ReceiptsContestPrizesListItemForm',
    () => import('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesListItemForm.vue'),
);

prizes.init();
