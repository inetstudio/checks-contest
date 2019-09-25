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
                                label="Продукт"
                                name="product_id"
                                v-bind:attributes="{
                                    'data-placeholder': 'Выберите продукт'
                                }"
                                v-bind:options="options.products"
                                v-bind:selected="product.model.product_id"
                                v-on:update:selected="selectProduct($event)"
                        />

                        <base-date
                                label="Дата"
                                v-bind:name="[
                                    'date_start',
                                    'date_end'
                                ]"
                                v-bind:value="[
                                    product.model.date_start,
                                    product.model.date_end,
                                ]"
                                v-bind:attributes="{
                                    'data-options': JSON.stringify(attributes)
                                }"
                                v-on:update:date_start="product.model.date_start = $event"
                                v-on:update:date_end="product.model.date_end = $event"
                        />

                        <base-checkboxes
                                label="Подтвердить"
                                name="confirmed"
                                v-bind:checkboxes="[
                                    {
                                        value: 1,
                                        label: ''
                                    }
                                ]"
                                v-bind:selected="product.model.confirmed"
                                v-on:update:selected="product.model.confirmed = $event"
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
          products: []
        },
        product: {},
        attributes: {
          dateFormat: 'd.m.Y',
          enableTime: false
        }
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['products'].state.mode;
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

        component.product = JSON.parse(JSON.stringify(window.Admin.vue.stores['products'].state.emptyProduct));

        let url = route('back.checks-contest.products.getSuggestions');

        axios.post(url).then(response => {
          component.options.products = _.map(response.data.items, function (item) {
            return {
                value: item.id,
                text: item.name
            };
          });

          component.options.loading = false;
        });
      },
      loadProduct() {
        let component = this;

        component.product = JSON.parse(JSON.stringify(window.Admin.vue.stores['products'].state.product));

        $('#product_id').val(component.product.model.product_id).trigger('change');
        $('#date_start')[0]._flatpickr.setDate(component.product.model.date_start);
        $('#date_end')[0]._flatpickr.setDate(component.product.model.date_end);
      },
      saveProduct() {
        let component = this;

        if (window.Admin.vue.stores['products'].state.mode === 'add_list_item'
            && window.Admin.vue.stores['products'].state.productsIds.indexOf(parseInt(component.product.model.product_id)) > -1) {

          $(this.$refs.modal).modal('hide');

          return;
        } else if (component.product.isModified && component.product.model.product_id !== 0) {
          window.Admin.vue.stores['products'].commit('setProduct', JSON.parse(JSON.stringify(component.product)));
          window.Admin.vue.stores['products'].commit('setMode', 'save_list_item');
        }

        $(this.$refs.modal).modal('hide');
      },
      selectProduct(data) {
        if (data) {
          this.product.model.product_id = data;
          this.product.model.name = $('#product_id option[value='+data+']').text();
        }
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
        });

        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.product = JSON.parse(JSON.stringify(window.Admin.vue.stores['products'].state.emptyProduct));
          $('#product_id').val(null).trigger('change');
        });
      });
    },
  };
</script>

<style scoped>
</style>
