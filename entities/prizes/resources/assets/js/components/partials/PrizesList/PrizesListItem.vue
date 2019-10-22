<template>
    <li>
        <div class="row">
            <div class="col-10">
                <i v-if="prize.model.confirmed[0]" class="fa fa-check-square"></i><span class="m-l-xs">{{ prize.model.name }}</span>
            </div>
            <div class="col-2">
                <div class="btn-group float-right">
                    <a href="#" class="btn btn-xs btn-default edit-prize m-r" v-on:click.prevent.stop="editPrize"><i class="fa fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-xs btn-danger delete-prize" v-on:click.prevent.stop="removePrize"><i class="fa fa-times"></i></a>
                </div>
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
      editPrize() {
        this.initPrizesComponent();

        window.Admin.vue.stores['checks_contest_prizes'].commit('setMode', 'edit_list_item');

        let prize = JSON.parse(JSON.stringify(this.prize));
        prize.isModified = false;

        window.Admin.vue.stores['checks_contest_prizes'].commit('setPrize', prize);

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
