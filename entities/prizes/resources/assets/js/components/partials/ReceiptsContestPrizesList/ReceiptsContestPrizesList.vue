<template>
    <div class="receipts_contest_prizes-package">
        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="add">Добавить</a>
        <ul class="prizes-list m-t small-list">
            <receipts-contest-prizes-list-item
                  v-for="prize in prizes"
                  :key="prize.model.id"
                  v-bind:prize="prize"
                  v-on:remove="remove"
            />
        </ul>
    </div>
</template>

<script>
  import hash from 'object-hash';
  import Swal from 'sweetalert2';

  export default {
    name: 'ReceiptsContestPrizesList',
    props: {
      prizesProp: {
        type: Array,
        default: function() {
          return [];
        }
      },
    },
    data() {
      return {
        prizes: []
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['receipts_contest_prizes'].state.mode;
      }
    },
    watch: {
      mode: function(newMode, oldMode) {
        let component = this;

        if (newMode === 'save_list_item' && (oldMode === 'add_list_item' || oldMode === 'edit_list_item')) {
          component.save();
        }
      },
      prizesProp: {
        immediate: true,
        handler (newValues, oldValues) {
          let component = this;

          component.prizes = _.map(JSON.parse(JSON.stringify(newValues)), function (prize) {
            if (prize.hasOwnProperty('model')) {
              prize.hash = hash(prize.model);

              return prize;
            }

            return {
              hash: hash(prize),
              model: prize
            };
          });

          window.Admin.vue.stores['receipts_contest_prizes'].commit('setPrizes', component.prizes);
        }
      }
    },
    methods: {
      add() {
        window.Admin.vue.helpers.initComponent('receipts_contest_prizes', 'ReceiptsContestPrizesListItemForm', {});

        window.Admin.vue.stores['receipts_contest_prizes'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['receipts_contest_prizes'].commit('newPrize');

        window.waitForElement('#receipts_contest_prizes_list_item_form_modal', function () {
          $('#receipts_contest_prizes_list_item_form_modal').modal();
        });
      },
      remove(payload) {
        let component = this;

        Swal.fire({
          title: 'Вы уверены?',
          icon: 'warning',
          showCancelButton: true,
          cancelButtonText: 'Отмена',
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Да, удалить'
        }).then((result) => {
          if (result.value) {
            component.prizes = _.remove(component.prizes, function (prize) {
              return prize.model.id !== payload.id;
            });

            window.Admin.vue.stores['receipts_contest_prizes'].commit('setPrizes', component.prizes);

            component.$emit('update:prizes', {
              prizes: component.prizes
            });
          }
        });
      },
      save() {
        let component = this;

        let storePrize = JSON.parse(JSON.stringify(window.Admin.vue.stores['receipts_contest_prizes'].state.prize));
        storePrize.hash = hash(storePrize.model);

        let index = component.getPrizeIndex(storePrize.model.id);

        if (index > -1) {
          component.$set(component.prizes, index, storePrize);
        } else {
          component.prizes.push(storePrize);
        }

        window.Admin.vue.stores['receipts_contest_prizes'].commit('setPrizes', component.prizes);

        component.$emit('update:prizes', {
          prizes: component.prizes
        });
      },
      getPrizeIndex(id) {
        let component = this;

        return _.findIndex(component.prizes, function(prize) {
          return prize.model.id === id;
        });
      }
    }
  };
</script>

<style scoped>
</style>
