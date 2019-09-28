<template>
    <div>
        <div class="form-group row checks_contest_prizes-package">
            <label class="col-sm-2 col-form-label font-bold">Призы</label>
            <div class="col-sm-10">
                <div class="ibox float-e-margins">
                    <div class="ibox-content no-borders">
                        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="addPrize">Добавить</a>
                        <ul class="prizes-list m-t small-list">
                            <prizes-list-item
                                    v-for="prize in prizes"
                                    :key="prize.model.id"
                                    v-bind:prize="prize"
                                    v-on:remove="removePrize"
                            />
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>
    </div>
</template>

<script>
  export default {
    name: 'PrizesList',
    props: {
      prizesProp: {
        type: Array,
        default: function() {
          return [];
        },
      },
    },
    data() {
      return {
        prizes: this.preparePrizes(),
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['checks_contest_prizes'].state.mode;
      },
    },
    watch: {
      mode: function(newMode) {
        if (newMode === 'save_list_item') {
          this.savePrize();
        }
      },
      prizessProp: function() {
        this.prizes = this.preparePrizes();
      },
    },
    methods: {
      preparePrizes() {
        let component = this;
        let prizes = [];

        this.prizesProp.forEach(function(element) {
          prizes.push({
            isModified: false,
            model: {
              id: element.id,
              name: element.name,
              prize_id: element.id.toString(),
              confirmed: (element.pivot.confirmed === 1) ? ['1'] : [],
              date_start: (element.pivot.date_start) ? component.getDate(element.pivot.date_start) : '',
              date_end: (element.pivot.date_end) ? component.getDate(element.pivot.date_end) : ''
            },
            hash: window.hash(element),
          });

          window.Admin.vue.stores['checks_contest_prizes'].commit('addPrizeId', element.id);
        });

        return prizes;
      },
      initPrizesComponent() {
        if (typeof window.Admin.vue.modulesComponents.$refs['checks_contest_prizes_PrizesListItemForm'] ==
            'undefined') {
          window.Admin.vue.modulesComponents.modules.checks_contest_prizes.components = _.union(
              window.Admin.vue.modulesComponents.modules.checks_contest_prizes.components, [
                {
                  name: 'PrizesListItemForm',
                  data: {},
                },
              ]);
        }
      },
      addPrize() {
        this.initPrizesComponent();

        window.Admin.vue.stores['checks_contest_prizes'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['checks_contest_prizes'].commit('setPrize', {});

        window.waitForElement('#prizes_list_item_form_modal', function() {
          $('#prizes_list_item_form_modal').modal();
        });
      },
      removePrize(payload) {
        let component = this;

        swal({
          title: 'Вы уверены?',
          type: 'warning',
          showCancelButton: true,
          cancelButtonText: 'Отмена',
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Да, удалить',
        }).then((result) => {
          if (result.value) {
            this.prizes = _.remove(this.prizes, function(prize) {
              return prize.model.id !== payload.id;
            });

            window.Admin.vue.stores['checks_contest_prizes'].commit('removePrizeId', payload.id);

            component.$emit('update:prizes', {
              prizes: _.map(this.prizes, 'model'),
            });
          }
        });
      },
      savePrize() {
        let component = this;

        let storePrize = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_prizes'].state.prize));
        storePrize.hash = window.hash(storePrize.model);

        let index = this.getPrizeIndex(storePrize.model.id);

        if (index > -1) {
          this.$set(this.prizes, index, storePrize);
        } else {
          this.prizes.push(storePrize);

          window.Admin.vue.stores['checks_contest_prizes'].commit('addPrizeId', parseInt(storePrize.model.prize_id));
        }

        component.$emit('update:prizes', {
          prizes: _.map(this.prizes, 'model'),
        });
      },
      getPrizeIndex(id) {
        return _.findIndex(this.prizes, function(prize) {
          return prize.model.id === id;
        });
      },
      getDate(dateTime) {
        return flatpickr.formatDate(flatpickr.parseDate(dateTime, 'Y-m-d H:i:s'), 'd.m.Y');
      }
    },
  };
</script>

<style scoped>
</style>
