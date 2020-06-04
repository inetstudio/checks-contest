<template>
    <div class="modal inmodal fade" id="receipts_contest_products_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span>
                    </button>
                    <h1 class="modal-title">Продукт</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-dropdown
                            label="Категория товара"
                            v-bind:attributes="{
                                label: 'text',
                                placeholder: 'Выберите категорию',
                                clearable: true,
                                reduce: option => option.value
                            }"
                            v-bind:options="options.categories"
                            v-bind:selected="_.get(product, 'model.product_data.category', null)"
                            v-on:update:selected="_.set(product, 'model.product_data.category', $event)"
                        />

                        <base-input-text
                            label="Название"
                            name="name"
                            v-bind:attributes="{
                                disabled: mode === 'edit_list_item' && _.get(product, 'model.fns_receipt_id', 0) !== 0
                            }"
                            v-bind:value="_.get(product, 'model.name', '')"
                            v-on:update:value="_.set(product, 'model.name', $event)"
                        />

                        <base-input-text
                            label="Количество"
                            name="quantity"
                            v-bind:attributes="{
                                disabled: mode === 'edit_list_item' && _.get(product, 'model.fns_receipt_id', 0) !== 0
                            }"
                            v-bind:value="_.get(product, 'model.quantity', 0)"
                            v-on:update:value="_.set(product, 'model.quantity', $event)"
                        />

                        <base-input-text
                            label="Стоимость единицы товара"
                            name="price"
                            v-bind:attributes="{
                                disabled: mode === 'edit_list_item' && _.get(product, 'model.fns_receipt_id', 0) !== 0
                            }"
                            v-bind:value="_.get(product, 'model.price', 0)"
                            v-on:update:value="_.set(product, 'model.price', $event)"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ReceiptsContestProductsListItemForm',
    data() {
      return {
        options: {
          loading: true,
          categories: [
            {
              value: 'beauty',
              text: 'Бьюти',
            }
          ]
        },
        product: {}
      };
    },
    computed: {
      _() {
        return _;
      },
      mode() {
        return window.Admin.vue.stores['receipts_contest_products'].state.mode;
      }
    },
    watch: {
      'product.model': {
        handler: function(newValue, oldValue) {
          let component = this;

          component.product.hash = window.hash(newValue);
        },
        deep: true
      }
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.options.loading = false;
      },
      loadProduct() {
        let component = this;

        let storeProduct = JSON.parse(JSON.stringify(window.Admin.vue.stores['receipts_contest_products'].state.product));
        _.set(storeProduct, 'model.quantity', component.formatNumber(_.get(storeProduct, 'model.quantity', 0), 3))
        _.set(storeProduct, 'model.price', component.formatNumber(_.get(storeProduct, 'model.price', 0) / 100, 2))

        component.product = storeProduct;
      },
      save() {
        let component = this;

        if (_.get(component.product, 'model.name', '') === '') {
          $(component.$refs.modal).modal('hide');

          return;
        }

        component.product.model.quantity = component.formatNumber(component.product.model.quantity, 3)
        component.product.model.price = parseInt(component.prepareNumber(component.product.model.price)) * 100

        window.Admin.vue.stores['receipts_contest_products'].commit('setProduct', JSON.parse(JSON.stringify(component.product.model)));
        window.Admin.vue.stores['receipts_contest_products'].commit('setMode', 'save_list_item');

        $(component.$refs.modal).modal('hide');
      },
      prepareNumber(number) {
        number = String(number)
        number = number.replace(',', '.');
        number = number.replace( /^([^.]*\.)(.*)$/, function (a, b, c) {
          return b + c.replace( /\./g, '' );
        });

        number = number.replace(/[^0-9.]/g, '');

        return number;
      },
      formatNumber(number, fractionDigits) {
        number = this.prepareNumber(number);

        return parseFloat(number).toFixed(fractionDigits);
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      component.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function () {
          component.loadProduct();
        });
      });
    }
  };
</script>

<style scoped>
</style>
