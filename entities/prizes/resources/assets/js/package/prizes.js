let prizes = {};

prizes.init = function() {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('prizes')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          prizes: {
            components: [],
          },
        });
  }

  $(document).ready(function() {
    if (typeof window.Admin.vue.modulesComponents.$refs['checks_contest_PrizesListItemForm'] ==
        'undefined') {
      window.Admin.vue.modulesComponents.modules.prizes.components = _.union(
          window.Admin.vue.modulesComponents.modules.prizes.components, [
            {
              name: 'PrizesListItemForm',
              data: {},
            },
          ]);
    }
  });
};

module.exports = prizes;
