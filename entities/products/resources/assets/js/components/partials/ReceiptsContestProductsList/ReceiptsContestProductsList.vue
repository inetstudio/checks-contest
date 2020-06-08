<template>
    <div class="receipts_contest_products-package">
        <a href="#" class="btn btn-xs btn-primary btn-xs m-b-lg" v-on:click.prevent="add">Добавить</a>
        <table class="table table-hover">
            <tbody>
            <tr>
                <th></th>
                <th>Продукт</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Сумма</th>
                <th></th>
            </tr>
            <receipts-contest-products-list-item
                v-for="product in products"
                :key="product.model.id"
                v-bind:product="product"
                v-on:remove="remove"
            />
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Итого:</strong></td>
                <td><strong>{{ total }}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
  export default {
    name: 'ReceiptsContestProductsList',
    props: {
      receiptIdProp: {
        type: [Number, String],
        required: true
      },
      fnsReceiptIdProp: {
        type: [Number, String],
        default: 0
      },
      productsProp: {
        type: Array,
        default: function() {
          return [];
        }
      }
    },
    data() {
      return {
        products: []
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['receipts_contest_products'].state.mode;
      },
      total() {
        let component = this;

        let total = 0;

        component.products.forEach(function (product) {
          total += (product.model.quantity * product.model.price / 100);
        });

        return Number(total.toFixed(2));
      }
    },
    watch: {
      mode: function(newMode, oldMode) {
        let component = this;

        if (newMode === 'save_list_item' && (oldMode === 'add_list_item' || oldMode === 'edit_list_item')) {
          component.save();
        }
      },
      productsProp: {
        immediate: true,
        handler (newValues, oldValues) {
          let component = this;

          component.products = _.map(JSON.parse(JSON.stringify(newValues)), function (product) {
            if (product.hasOwnProperty('model')) {
              product.hash = window.hash(product.model);

              return product;
            }

            return {
              hash: window.hash(product),
              model: product
            };
          });

          window.Admin.vue.stores['receipts_contest_products'].commit('setProducts', component.products);
        }
      }
    },
    methods: {
      add() {
        let component = this;

        window.Admin.vue.helpers.initComponent('receipts_contest_products', 'ReceiptsContestProductsListItemForm', {});

        window.Admin.vue.stores['receipts_contest_products'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['receipts_contest_products'].commit('newProduct', component.receiptIdProp);

        window.waitForElement('#receipts_contest_products_list_item_form_modal', function() {
          $('#receipts_contest_products_list_item_form_modal').modal();
        });
      },
      remove(payload) {
        let component = this;

        swal({
          title: 'Вы уверены?',
          type: 'warning',
          showCancelButton: true,
          cancelButtonText: 'Отмена',
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Да, удалить'
        }).then((result) => {
          if (result.value) {
            component.products = _.remove(component.products, function (product) {
              return product.model.id !== payload.id;
            });

            window.Admin.vue.stores['receipts_contest_products'].commit('setProducts', component.products);

            component.$emit('update:products', {
              products: component.products
            });
          }
        });
      },
      save() {
        let component = this;

        let storeProduct = JSON.parse(JSON.stringify(window.Admin.vue.stores['receipts_contest_products'].state.product));
        storeProduct.hash = window.hash(storeProduct.model);

        let index = component.getProductIndex(storeProduct.model.id);

        if (index > -1) {
          component.$set(component.products, index, storeProduct);
        } else {
          component.products.push(storeProduct);
        }

        window.Admin.vue.stores['receipts_contest_products'].commit('setProducts', component.products);

        component.$emit('update:products', {
          products: component.products
        });
      },
      getProductIndex(id) {
        let component = this;

        return _.findIndex(component.products, function(product) {
          return product.model.id === id;
        });
      }
    }
  };
</script>

<style scoped>
</style>
