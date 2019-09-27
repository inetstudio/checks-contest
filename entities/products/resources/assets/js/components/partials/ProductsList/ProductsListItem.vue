<template>
    <tr>
        <td>{{ product.model.name }}</td>
        <td>{{ product.model.quantity }}</td>
        <td>{{ product.model.price }}</td>
        <td>{{ this.getSum(product.model) }}</td>
        <td>
            <div class="float-right">
                <a href="#" class="btn btn-xs btn-default edit-product m-r-xs"
                   v-on:click.prevent.stop="editProduct"><i class="fa fa-pencil-alt"></i></a>
                <a href="#" class="btn btn-xs btn-danger delete-product" v-on:click.prevent.stop="removeProduct"><i
                        class="fa fa-times"></i></a>
            </div>
            <input :name="'products[' + product.model.id + '][name]'" type="hidden" :value="product.model.name">
            <input :name="'products[' + product.model.id + '][quantity]'" type="hidden" :value="product.model.quantity">
            <input :name="'products[' + product.model.id + '][price]'" type="hidden" :value="product.model.price">
            <input :name="'products[' + product.model.id + '][product_data]'" type="hidden" :value="JSON.stringify(product.model.product_data)">
        </td>
    </tr>
</template>

<script>
  export default {
    name: 'ProductsListItem',
    props: {
      product: {
        type: Object,
        required: true,
      },
    },
    methods: {
      initProductsComponent() {
        if (typeof window.Admin.vue.modulesComponents.$refs['checks_contest_products_ProductsListItemForm'] == 'undefined') {
          window.Admin.vue.modulesComponents.modules.checks_contest_products.components = _.union(
              window.Admin.vue.modulesComponents.modules.checks_contest_products.components, [
                {
                  name: 'ProductsListItemForm',
                  data: {},
                },
              ]);
        }
      },
      editProduct() {
        this.initProductsComponent();

        window.Admin.vue.stores['checks_contest_products'].commit('setMode', 'edit_list_item');

        let product = JSON.parse(JSON.stringify(this.product));
        product.isModified = false;

        window.Admin.vue.stores['checks_contest_products'].commit('setProduct', product);

        window.waitForElement('#products_list_item_form_modal', function() {
          $('#products_list_item_form_modal').modal();
        });
      },
      removeProduct() {
        this.$emit('remove', {
          id: this.product.model.id,
        });
      },
      getSum(product) {
        return (product.quantity * product.price).toFixed(2);
      }
    },
  };
</script>

<style scoped>
</style>
