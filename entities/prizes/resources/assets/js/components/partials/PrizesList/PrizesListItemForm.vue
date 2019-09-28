<template>
    <div class="modal inmodal fade" id="prizes_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true"
         ref="modal">
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

                        <base-dropdown
                                label="Приз"
                                name="prize_id"
                                v-bind:attributes="{
                                    'data-placeholder': 'Выберите приз'
                                }"
                                v-bind:options="options.prizes"
                                v-bind:selected="prize.model.prize_id"
                                v-on:update:selected="selectPrize($event)"
                        />

                        <base-date
                                label="Дата"
                                v-bind:name="[
                                    'date_start',
                                    'date_end'
                                ]"
                                v-bind:value="[
                                    prize.model.date_start,
                                    prize.model.date_end,
                                ]"
                                v-bind:attributes="{
                                    'data-options': JSON.stringify(attributes)
                                }"
                                v-on:update:date_start="prize.model.date_start = $event"
                                v-on:update:date_end="prize.model.date_end = $event"
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
                                v-bind:selected="prize.model.confirmed"
                                v-on:update:selected="prize.model.confirmed = $event"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="savePrize">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'PrizesListItemForm',
    data() {
      return {
        options: {
          loading: true,
          prizes: []
        },
        prize: {},
        attributes: {
          dateFormat: 'd.m.Y',
          enableTime: false
        }
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['checks_contest_prizes'].state.mode;
      },
    },
    watch: {
      'prize.model': {
        handler: function(newValue, oldValue) {
          this.prize.isModified = !(!newValue
              || typeof newValue.id === 'undefined'
              || typeof oldValue.id === 'undefined'
              || this.prize.hash === window.hash(newValue));
        },
        deep: true,
      },
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.prize = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_prizes'].state.emptyPrize));

        let url = route('back.checks-contest.prizes.getSuggestions');

        axios.post(url).then(response => {
          component.options.prizes = _.map(response.data.items, function (item) {
            return {
              value: item.id,
              text: item.name
            };
          });

          component.options.loading = false;
        });
      },
      loadPrize() {
        let component = this;

        component.prize = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_prizes'].state.prize));

        $('#prize_id').val(component.prize.model.prize_id).trigger('change');
        $('#date_start')[0]._flatpickr.setDate(component.prize.model.date_start);
        $('#date_end')[0]._flatpickr.setDate(component.prize.model.date_end);
      },
      savePrize() {
        let component = this;

        if (window.Admin.vue.stores['checks_contest_prizes'].state.mode === 'add_list_item'
            && window.Admin.vue.stores['checks_contest_prizes'].state.prizesIds.indexOf(parseInt(component.prize.model.prize_id)) > -1) {

          $(this.$refs.modal).modal('hide');

          return;
        } else if (component.prize.isModified && component.prize.model.prize_id !== 0) {
          window.Admin.vue.stores['checks_contest_prizes'].commit('setPrize', JSON.parse(JSON.stringify(component.prize)));
          window.Admin.vue.stores['checks_contest_prizes'].commit('setMode', 'save_list_item');
        }

        $(this.$refs.modal).modal('hide');
      },
      selectPrize(data) {
        if (data) {
          this.prize.model.prize_id = data;
          this.prize.model.name = $('#prize_id option[value='+data+']').text();
        }
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function() {
          component.loadPrize();
        });

        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.prize = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_prizes'].state.emptyPrize));
          $('#prize_id').val(null).trigger('change');
        });
      });
    },
  };
</script>

<style scoped>
</style>
