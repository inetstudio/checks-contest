import {prizes} from './package/receipts_contest_prizes';

require('./stores/receipts_contest_prizes');

window.Vue.component(
    'ReceiptsContestPrizesList',
    require('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesList.vue').default,
);
window.Vue.component(
    'ReceiptsContestPrizesListItem',
    require('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesListItem.vue').default,
);
window.Vue.component(
    'ReceiptsContestPrizesListItemForm',
    require('./components/partials/ReceiptsContestPrizesList/ReceiptsContestPrizesListItemForm.vue').default,
);

prizes.init();
