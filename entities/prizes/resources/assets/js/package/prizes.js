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
};

module.exports = prizes;
