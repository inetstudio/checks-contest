require('./stores/prizes');

Vue.component(
    'ChecksContestPrizesList',
    require('./components/partials/PrizesList/PrizesList.vue').default,
);
Vue.component(
    'ChecksContestPrizesListItem',
    require('./components/partials/PrizesList/PrizesListItem.vue').default,
);
Vue.component(
    'ChecksContestPrizesListItemForm',
    require('./components/partials/PrizesList/PrizesListItemForm.vue').default,
);

let prizes = require('./package/prizes');
prizes.init();
