<template>
    <li>
        <div class="row">
            <div class="col-10">
                <i v-if="product.model.confirmed[0]" class="fa fa-check-square"></i><span class="m-l-xs">{{ product.model.name }}</span>
            </div>
            <div class="col-2">
                <div class="float-right">
                    <a href="#" class="btn btn-xs btn-default edit-product m-r-xs"
                       v-on:click.prevent.stop="editProduct"><i class="fa fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-xs btn-danger delete-product" v-on:click.prevent.stop="removeProduct"><i
                            class="fa fa-times"></i></a>
                </div>
                <input :name="'products[' + product.model.product_id + '][date_start]'" type="hidden" :value="product.model.date_start">
                <input :name="'products[' + product.model.product_id + '][date_end]'" type="hidden" :value="product.model.date_end">
                <input :name="'products[' + product.model.product_id + '][confirmed]'" type="hidden" :value="product.model.confirmed[0] || ''">
            </div>
        </div>
    </li>
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
        if (typeof window.Admin.vue.modulesComponents.$refs['checks_contest_ProductsListItemForm'] ==
            'undefined') {
          window.Admin.vue.modulesComponents.modules.products.components = _.union(
              window.Admin.vue.modulesComponents.modules.products.components, [
                {
                  name: 'ProductsListItemForm',
                  data: {},
                },
              ]);
        }
      },
      editProduct() {
        this.initProductsComponent();

        window.Admin.vue.stores['products'].commit('setMode', 'edit_list_item');

        let product = JSON.parse(JSON.stringify(this.product));
        product.isModified = false;

        window.Admin.vue.stores['products'].commit('setProduct', product);

        window.waitForElement('#products_list_item_form_modal', function() {
          $('#products_list_item_form_modal').modal();
        });
      },
      removeProduct() {
        this.$emit('remove', {
          id: this.product.model.id,
        });
      },
    },
  };
</script>

<style scoped>
</style>
