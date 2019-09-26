let products = {};

products.init = function() {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('products')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          products: {
            components: [],
          },
        });
  }
};

module.exports = products;
