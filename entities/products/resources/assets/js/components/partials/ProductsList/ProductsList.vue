<template>
    <div>
        <div class="form-group row checks_contest_products-package">
            <label class="col-sm-2 col-form-label font-bold">Продукты</label>
            <div class="col-sm-10">
                <div class="ibox float-e-margins">
                    <div class="ibox-content no-borders">
                        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="addProduct">Добавить</a>
                        <ul class="products-list m-t small-list">
                            <products-list-item
                                v-for="product in products"
                                :key="product.model.id"
                                v-bind:product="product"
                                v-on:remove="removeProduct"
                            />
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>
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
    },
    data() {
      return {
        products: this.prepareProducts(),
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['products'].state.mode;
      },
    },
    watch: {
      mode: function(newMode) {
        if (newMode === 'save_list_item') {
          this.saveProduct();
        }
      },
      productssProp: function() {
        this.products = this.prepareProducts();
      },
    },
    methods: {
      prepareProducts() {
        let component = this;
        let products = [];

        this.productsProp.forEach(function(element) {
          products.push({
            isModified: false,
            model: {
              id: element.id,
              name: element.name,
              product_id: element.id.toString(),
              confirmed: (element.pivot.confirmed === 1) ? ['1'] : [],
              date_start: (element.pivot.date_start) ? component.getDate(element.pivot.date_start) : '',
              date_end: (element.pivot.date_end) ? component.getDate(element.pivot.date_end) : ''
            },
            hash: window.hash(element),
          });

          window.Admin.vue.stores['products'].commit('addProductId', element.id);
        });

        return products;
      },
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
      addProduct() {
        this.initProductsComponent();

        window.Admin.vue.stores['products'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['products'].commit('setProduct', {});

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

            window.Admin.vue.stores['products'].commit('removeProductId', payload.id);

            component.$emit('update:products', {
              products: _.map(this.products, 'model'),
            });
          }
        });
      },
      saveProduct() {
        let component = this;

        let storeProduct = JSON.parse(JSON.stringify(window.Admin.vue.stores['products'].state.product));
        storeProduct.hash = window.hash(storeProduct.model);

        let index = this.getProductIndex(storeProduct.model.id);

        if (index > -1) {
          this.$set(this.products, index, storeProduct);
        } else {
          this.products.push(storeProduct);

          window.Admin.vue.stores['products'].commit('addProductId', parseInt(storeProduct.model.product_id));
        }

        component.$emit('update:products', {
          products: _.map(this.products, 'model'),
        });
      },
      getProductIndex(id) {
        return _.findIndex(this.products, function(product) {
          return product.model.id === id;
        });
      },
      getDate(dateTime) {
        return flatpickr.formatDate(flatpickr.parseDate(dateTime, 'Y-m-d H:i:s'), 'd.m.Y');
      }
    },
  };
</script>

<style scoped>
</style>
