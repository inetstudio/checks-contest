require('./stores/prizes');

Vue.component(
    'PrizesList',
    require('./components/partials/PrizesList/PrizesList.vue').default,
);
Vue.component(
    'PrizesListItem',
    require('./components/partials/PrizesList/PrizesListItem.vue').default,
);
Vue.component(
    'PrizesListItemForm',
    require('./components/partials/PrizesList/PrizesListItemForm.vue').default,
);

let prizes = require('./package/prizes');
prizes.init();
