<template>
    <tr v-bind:style="{ 'background-color': (product.model.highlight ? 'rgba(66, 234, 57, 0.275)' : '') }">
        <td><span class="label label-default" v-if="getProductCategory(product)">{{ getProductCategory(product) }}</span></td>
        <td>{{ product.model.name }}</td>
        <td>{{ product.model.quantity }}</td>
        <td>{{ productPrice }}</td>
        <td>{{ getSum(product.model) }}</td>
        <td>
            <div class="btn-group float-right">
                <a href="#" class="btn btn-xs btn-default m-r edit-product" v-on:click.prevent.stop="edit">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                <a href="#" class="btn btn-xs btn-danger delete-product" v-on:click.prevent.stop="remove">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </td>
    </tr>
</template>

<script>
  export default {
    name: 'ReceiptsContestProductsListItem',
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    computed: {
      productPrice() {
        let component = this;

        return (component.product.model.price / 100).toFixed(2);
      }
    },
    methods: {
      edit() {
        let component = this;

        window.Admin.vue.helpers.initComponent('receipts_contest_products', 'ReceiptsContestProductsListItemForm', {});

        window.Admin.vue.stores['receipts_contest_products'].commit('setMode', 'edit_list_item');
        window.Admin.vue.stores['receipts_contest_products'].commit('setProduct', component.product);

        window.waitForElement('#receipts_contest_products_list_item_form_modal', function () {
          $('#receipts_contest_products_list_item_form_modal').modal();
        });
      },
      remove() {
        let component = this;

        component.$emit('remove', {
          id: component.product.model.id
        });
      },
      getProductCategory(product) {
        return _.get(product, 'model.product_data.category', null);
      },
      getSum(product) {
        return Number((product.quantity * product.price / 100).toFixed(2));
      }
    },
  };
</script>

<style scoped>
</style>
