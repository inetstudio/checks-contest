<template>
    <li>
        <div class="row">
            <div class="col-10">
                <i v-if="prize.model.confirmed[0]" class="fa fa-check-square"></i><span class="m-l-xs">{{ prize.model.name }}</span>
            </div>
            <div class="col-2">
                <div class="float-right">
                    <a href="#" class="btn btn-xs btn-default edit-prize m-r-xs"
                       v-on:click.prevent.stop="editPrize"><i class="fa fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-xs btn-danger delete-prize" v-on:click.prevent.stop="removePrize"><i
                            class="fa fa-times"></i></a>
                </div>
                <input :name="'prizes[' + prize.model.prize_id + '][date_start]'" type="hidden" :value="prize.model.date_start">
                <input :name="'prizes[' + prize.model.prize_id + '][date_end]'" type="hidden" :value="prize.model.date_end">
                <input :name="'prizes[' + prize.model.prize_id + '][confirmed]'" type="hidden" :value="prize.model.confirmed[0] || ''">
            </div>
        </div>
    </li>
</template>

<script>
  export default {
    name: 'PrizesListItem',
    props: {
      prize: {
        type: Object,
        required: true,
      },
    },
    methods: {
      initPrizesComponent() {
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
      },
      editPrize() {
        this.initPrizesComponent();

        window.Admin.vue.stores['prizes'].commit('setMode', 'edit_list_item');

        let prize = JSON.parse(JSON.stringify(this.prize));
        prize.isModified = false;

        window.Admin.vue.stores['prizes'].commit('setPrize', prize);

        window.waitForElement('#prizes_list_item_form_modal', function() {
          $('#prizes_list_item_form_modal').modal();
        });
      },
      removePrize() {
        this.$emit('remove', {
          id: this.prize.model.id,
        });
      },
    },
  };
</script>

<style scoped>
</style>
