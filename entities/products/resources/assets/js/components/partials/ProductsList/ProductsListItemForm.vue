<template>
    <div class="modal inmodal fade" id="products_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true"
         ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Продукт</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-dropdown
                                label = "Категория товара"
                                name = "product_type"
                                v-bind:attributes = "{
                                'data-placeholder': 'Выберите категорию товара',
                                'data-allow-clear': 'true'
                                }"
                                v-bind:options = "options.categories"
                                v-bind:selected.sync="product.model.product_data.category"
                        />

                        <base-input-text
                                label="Название"
                                name="answer"
                                v-bind:value.sync="product.model.name"
                        />

                        <base-input-text
                                label="Количество"
                                name="answer"
                                v-bind:value.sync="product.model.quantity"
                        />

                        <base-input-text
                                label="Стоимость единицы товара"
                                name="answer"
                                v-bind:value.sync="product.model.price"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="saveProduct">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ProductsListItemForm',
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
      mode() {
        return window.Admin.vue.stores['checks_contest_products'].state.mode;
      },
    },
    watch: {
      'product.model': {
        handler: function(newValue, oldValue) {
          this.product.isModified = !(!newValue
              || typeof newValue.id === 'undefined'
              || typeof oldValue.id === 'undefined'
              || this.product.hash === window.hash(newValue));
        },
        deep: true,
      },
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.product = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_products'].state.emptyProduct));

        component.options.loading = false;
      },
      loadProduct() {
        let component = this;

        component.product = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_products'].state.product));
      },
      saveProduct() {
        let component = this;

        if (component.product.isModified && component.product.model.name !== '' && component.product.model.quantity !== '' && component.product.model.price !== '') {
          window.Admin.vue.stores['checks_contest_products'].commit('setProduct', JSON.parse(JSON.stringify(component.product)));
          window.Admin.vue.stores['checks_contest_products'].commit('setMode', 'save_list_item');
        } else {
          $(this.$refs.modal).modal('hide');

          return;
        }

        $(this.$refs.modal).modal('hide');
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function() {
          component.loadProduct();

          let category = _.get(component.product, 'model.product_data.category', null);

          $('#product_type').val(category).trigger('change');
        });

        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.product = JSON.parse(JSON.stringify(window.Admin.vue.stores['checks_contest_products'].state.emptyProduct));
        });
      });
    },
  };
</script>

<style scoped>
</style>
