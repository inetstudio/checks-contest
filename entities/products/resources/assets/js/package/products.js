let products = {};

products.init = function() {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('checks_contest_products')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          checks_contest_products: {
            components: [],
          },
        });
  }
};

module.exports = products;
