<template>
    <div>
        <a href="#" class="btn btn-xs btn-primary btn-xs m-b-lg" v-on:click.prevent="addProduct">Добавить</a>
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
            <products-list-item
                v-for="product in products"
                :key="product.model.id"
                v-bind:product="product"
                v-on:remove="removeProduct"
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
        <input :name="'products'" type="hidden" :value="JSON.stringify(preparedProducts)">
    </div>
</template>

<script>
  export default {
    name: 'ProductsList',
    props: {
      productsProp: {
        type: Array,
        default: function() {
          return [];
        },
      },
      fnsReceiptIdProp: {
        type: Number,
        default: 0
      },
      receiptIdProp: {
        type: Number,
        default: 0
      },
    },
    data() {
      return {
        products: this.prepareProducts(),
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['checks_contest_products'].state.mode;
      },
      total() {
        let total = 0;

        this.products.forEach(function (product) {
          total += (product.model.quantity * product.model.price);
        });

        return total.toFixed(2);
      },
      preparedProducts() {
        let products = JSON.parse(JSON.stringify(this.products));

        return _.map(products, function (item) {
          item.model.price *= 100;

          return item.model;
        });
      }
    },
    watch: {
      mode: function(newMode) {
        if (newMode === 'save_list_item') {
          this.saveProduct();
        }
      },
      productsProp: function() {
        this.products = this.prepareProducts();
      },
    },
    methods: {
      formatNumber(number, fractionDigits) {
        number = String(number)
        number = number.replace(',', '.');
        number = number.replace( /^([^.]*\.)(.*)$/, function ( a, b, c ) {
          return b + c.replace( /\./g, '' );
        });
        number = number.replace(/[^0-9.]/g, '');

        return parseFloat(number).toFixed(fractionDigits);
      },
      prepareProducts() {
        let component = this;
        let products = [];

        this.productsProp.forEach(function(element) {
          products.push({
            isModified: false,
            model: {
              id: element.id,
              fns_receipt_id: element.fns_receipt_id,
              receipt_id: element.receipt_id,
              name: element.name,
              quantity: component.formatNumber(element.quantity, 3),
              price: (component.formatNumber(element.price, 2) / 100).toFixed(2),
              product_data: element.product_data || {},
              highlight: element.highlight
            },
            hash: window.hash(element),
          });
        });

        return products;
      },
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
      addProduct() {
        this.initProductsComponent();

        window.Admin.vue.stores['checks_contest_products'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['checks_contest_products'].commit('setProduct', {});

        window.waitForElement('#products_list_item_form_modal', function() {
          $('#products_list_item_form_modal').modal();
        });
      },
      removeProduct(payload) {
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
            this.products = _.remove(this.products, function(product) {
              return product.model.id !== payload.id;
            });

            component.$emit('update:products', {
              products: _.map(this.products, 'model'),
            });
          }
        });
      },
      saveProduct() {
        let component = this;

        let storeProduct = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_products'].state.product));
        storeProduct.hash = window.hash(storeProduct.model);
        storeProduct.model.price = component.formatNumber(storeProduct.model.price, 2);
        storeProduct.model.quantity = component.formatNumber(storeProduct.model.quantity, 3);

        let index = this.getProductIndex(storeProduct.model.id);

        if (index > -1) {
          this.$set(this.products, index, storeProduct);
        } else {
          this.products.push(storeProduct);
        }

        component.$emit('update:products', {
          products: _.map(this.products, 'model'),
        });
      },
      getProductIndex(id) {
        return _.findIndex(this.products, function(product) {
          return product.model.id === id;
        });
      }
    },
    created: function() {
      window.Admin.vue.stores['checks_contest_products'].commit('modifyEmptyProduct', {
        fns_receipt_id: this.fnsReceiptIdProp,
        receipt_id: this.receiptIdProp,
      });
    },
  };
</script>

<style scoped>
</style>
