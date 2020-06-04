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

let prizes = require('./package/receipts_contest_prizes');
prizes.init();
