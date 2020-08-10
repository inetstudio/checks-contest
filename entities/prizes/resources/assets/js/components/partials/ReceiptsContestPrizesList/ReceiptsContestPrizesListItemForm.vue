<template>
    <div class="modal inmodal fade" id="receipts_contest_prizes_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Приз</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <template v-if="options.ready">
                            <base-dropdown
                                    label="Приз"
                                    v-bind:attributes="{
                                      label: 'name',
                                      placeholder: 'Выберите приз',
                                      disabled: (mode === 'edit_list_item'),
                                      clearable: false,
                                      reduce: option => option.id
                                  }"
                                    v-bind:options="options.prizes"
                                    v-bind:selected=selectedPrize
                                    v-on:update:selected="selectPrize($event)"
                            />

                            <base-date
                                    label="Дата"
                                    v-bind:dates="[
                                      {
                                        name: 'date_start',
                                        value: formatDate(_.get(prize, 'model.pivot.date_start', null), 'Z', 'd.m.Y')
                                      },
                                      {
                                        name: 'date_end',
                                        value: formatDate(_.get(prize, 'model.pivot.date_end', null), 'Z', 'd.m.Y')
                                      }
                                  ]"
                                    v-bind:options="options.dates"
                                    v-on:update:date_start="prize.model.pivot.date_start = formatDate($event, 'd.m.Y', 'Z')"
                                    v-on:update:date_end="prize.model.pivot.date_end = formatDate($event, 'd.m.Y', 'Z')"
                            />

                            <base-checkboxes
                                    label="Подтвердить"
                                    name="confirmed"
                                    v-bind:checkboxes="[
                                      {
                                          value: 1,
                                          label: ''
                                      }
                                  ]"
                                    v-bind:selected="_.get(prize, 'model.pivot.confirmed', 0)"
                                    v-on:update:selected="prize.model.pivot.confirmed = (parseInt($event[0]) || 0)"
                            />
                        </template>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ReceiptsContestPrizesListItemForm',
    data() {
      return {
        options: {
          loading: true,
          ready: false,
          prizes: [],
          dates: {
            dateFormat: 'd.m.Y',
            enableTime: false
          }
        },
        prize: {}
      };
    },
    computed: {
      _() {
        return _;
      },
      mode() {
        return window.Admin.vue.stores['receipts_contest_prizes'].state.mode;
      },
      selectedPrize() {
        let component = this;

        let prizeIndex = _.findIndex(component.options.prizes, function (prize) {
          return prize.id === parseInt(component.prize.model.id);
        });

        if (prizeIndex > -1) {
          return component.options.prizes[prizeIndex].id;
        }
      }
    },
    watch: {
      'prize.model': {
        handler: function(newValue, oldValue) {
          let component = this;

          component.prize.hash = window.hash(newValue);
        },
        deep: true
      }
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.loadPrize();

        if (! component.options.ready ) {
          let url = route('back.receipts-contest.prizes.utility.suggestions');

          axios.post(url).then(response => {
            component.options.prizes = response.data.items;

            component.options.loading = false;
            component.options.ready = true;
          });
        }
      },
      loadPrize() {
        let component = this;

        component.prize = JSON.parse(JSON.stringify(window.Admin.vue.stores['receipts_contest_prizes'].state.prize));
      },
      save() {
        let component = this;

        let existsIndex = _.findIndex(window.Admin.vue.stores['receipts_contest_prizes'].state.prizes, function(prize) {
          return prize.model.id === _.get(component.prize, 'model.id', null);
        });

        if (typeof component.prize.model.alias === 'undefined' || existsIndex > -1 && component.mode === 'add_list_item') {
          $(component.$refs.modal).modal('hide');

          return;
        }

        window.Admin.vue.stores['receipts_contest_prizes'].commit('setPrize', JSON.parse(JSON.stringify(component.prize.model)));
        window.Admin.vue.stores['receipts_contest_prizes'].commit('setMode', 'save_list_item');

        $(component.$refs.modal).modal('hide');
      },
      selectPrize(id) {
        let component = this;

        if (id) {
          let prizeIndex = _.findIndex(component.options.prizes, function (prize) {
            return prize.id === parseInt(id);
          });

          if (prizeIndex > -1) {
            component.prize.model = _.merge(component.prize.model, component.options.prizes[prizeIndex]);
          }
        }
      },
      formatDate(dateTime, fromFormat, toFormat) {
        return dateTime ? flatpickr.formatDate(flatpickr.parseDate(dateTime, fromFormat), toFormat) : null;
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      component.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function () {
          component.loadPrize();
        });
      });
    }
  };
</script>

<style scoped>
</style>
