<template>
  <div class="container-md">
    <div>
      <BackButton :link-to="{name: 'invoice.index'}"/>
    </div>

    <div class="card my-2">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('invoice.edit') }}
      </div>

      <div class="card-body">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#invoice-head" class="nav-link active" data-toggle="tab">
              {{ $t('invoice.tabs.head') }}
            </a>
          </li>
          <li class="nav-item">
            <a href="#invoice-detail" class="nav-link" data-toggle="tab">
              {{ $t('invoice.tabs.detail') }}
            </a>
          </li>
        </ul>

        <div class="tab-content p-3">
          <div id="invoice-head" class="tab-pane active">
            <div class="row">
              <BaseSelect
                id="customer_id"
                v-model.number="invoice.customer_id"
                :title="$t('invoice.customer')"
                :errors="errors.customer_id"
                :items="customers"
                item-value="id"
                item-caption="name"
                form-group-class="col-lg-6 col-md-12"
              />
              <BaseText
                id="invoice_no"
                v-model="invoice.invoice_no"
                :title="$t('invoice.invoice_no')"
                :errors="errors.invoice_no"
                form-group-class="col-lg-6 col-md-12"
              />
              <BaseDatePicker
                id="invoice_date"
                v-model="invoice.invoice_date"
                :title="$t('invoice.invoice_date')"
                :errors="errors.invoice_date"
                form-group-class="col-lg-3 col-md-6"
              />
              <BaseDatePicker
                id="payment_due_date"
                v-model="invoice.payment_due_date"
                :title="$t('invoice.payment_due_date')"
                :errors="errors.payment_due_date"
                form-group-class="col-lg-3 col-md-6"
              />
              <BaseTextArea
                id="remarks"
                v-model="invoice.remarks"
                :title="$t('invoice.remarks')"
                :errors="errors.remarks"
                form-group-class="col-lg-6 col-md-12"
              />
            </div>
          </div>
          
          <div id="invoice-detail" class="tab-pane card p-0">
            <div class="card-header text-right">
              <button type="button" class="btn btn-primary mr-2" @click="addItem">
                {{ $t('common.add') }}
              </button>
              <button type="button" class="btn btn-danger" @click="deleteItem">
                {{ $t('common.delete') }}
              </button>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover m-0">
                <thead>
                  <tr class="table-secondary">
                    <th scope="col"><!-- CheckBoxColumn --></th>
                    <th
                      v-for="column in columns"
                      v-bind:key="column"
                      scope="col"
                      class="border-0"
                    >
                      {{ column }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="item in invoice.items"
                    v-bind:key="`invoice-item-${item.item_id}`"
                  >
                    <td class="align-middle">
                      <BaseCheckbox
                        v-model="item.selected"
                        form-group-class="m-0"
                        form-check-class="p-0"
                        form-check-input-class="m-0 position-relative"
                      />
                    </td>
                    <td class="align-middle">
                      {{ item.item_id }}
                    </td>
                    <td class="align-middle" style="min-width: 200px;">
                      <BaseSelect
                        :id="`product-id-${item.item_id}`"
                        v-model.number="item.product_id"
                        :errors="itemErrors[item.item_id - 1] ? itemErrors[item.item_id - 1].product_id : null"
                        :items="products"
                        item-value="id"
                        item-caption="name"
                        form-group-class="m-0"
                        @change-after="getProduct(item)"
                      />
                    </td>
                    <td class="align-middle">
                      <BaseNumber
                        v-model="item.product.price"
                        disabled
                        form-group-class="m-0"
                      />
                    </td>
                    <td class="align-middle">
                      <BaseNumber
                        v-model.number="item.quantity"
                        :errors="itemErrors[item.item_id - 1] ? itemErrors[item.item_id - 1].quantity : null"
                        form-group-class="m-0"
                        @input-after="calcAmount(item)"
                      />
                    </td>
                    <td class="align-middle">
                      <BaseNumber
                        :value="item.amount"
                        :errors="itemErrors[item.item_id - 1] ? itemErrors[item.item_id - 1].amount : null"
                        disabled
                        form-group-class="m-0"
                      />
                    </td>
                    <td class="align-middle">
                      <BaseText
                        v-model="item.remarks"
                        :errors="itemErrors[item.item_id - 1] ? itemErrors[item.item_id - 1].remarks : null"
                        form-group-class="m-0"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer text-right">
        <form
          @submit.prevent="save"
          @reset.prevent="init"
        >
          <button type="submit" class="btn btn-primary mr-2">
            {{ $t('common.save') }}
          </button>
          <button type="reset" class="btn btn-outline-primary">
            {{ $t('common.undo')}}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import toastedOptions from '@/settings/toasted-options'

export default {
  props: {
    invoiceId: {
      type: String
    },
  },

  data() {
    return {
      invoice: {},
      customers: [],
      products: [],
      errors: [],
      selector: 0,
    }
  },

  computed: {
    columns() {
      return [
        this.$t('invoice.item.id'),
        this.$t('invoice.item.product'),
        this.$t('invoice.item.price'),
        this.$t('invoice.item.quantity'),
        this.$t('invoice.item.amount'),
        this.$t('invoice.item.remarks'),
      ];
    },

    itemErrors() {
      return this.errors.items ? this.errors.items : [];
    },
  },

  watch: {
    amount: function (item) {
      return Math.floor(item.product.price * item.quantity);
    },
  },

  methods: {
    async init() {
      await axios.get('/api/customer').then(res => {
        this.customers = res.data;
      });

      await axios.get('/api/product').then(res => {
        this.products = res.data;
      });

      await axios.get('/api/invoice/' + this.invoiceId).then(res => {
        this.invoice = res.data;
      });

      if (this.invoice.items.length == 0) {
        await this.addItem();
      }

      this.errors = [];
    },

    async save() {
      axios.put('/api/invoice/' + this.invoiceId, this.invoice)
        .then(res => {
          this.$toasted.show(this.$t('common.notify.saved'), toastedOptions.success);
          this.errors = [];
        })
        .catch(ex => {
          this.$toasted.show(this.$t('common.notify.error'), toastedOptions.error);
          this.errors = ex.response.data.errors;
        });
    },

    addItem() {
      this.invoice.items.push({
        invoice_id: this.invoiceId,
        item_id: this.invoice.items.length + 1,
        product_id: null,
        product: {},
        quantity: 0,
        amount: 0,
        remarks: "",
      });
    },

    deleteItem() {
      for(let i = this.invoice.items.length - 1; i >= 0; i--) {
        if (this.invoice.items[i].selected) {
          this.invoice.items.splice(i, 1);
        }
      }

      for (let i = 0; i < this.invoice.items.length; i++) {
        this.invoice.items[i].item_id = i + 1;
      }
    },

    getProduct(item) {
      if (item.product_id) {
        let product = this.products.find(p => p.id == item.product_id);
        item.product = product;
      } else {
        item.product = {};
      }
    },

    calcAmount(item) {
      item.amount = Math.round(item.product.price * item.quantity);
    },
  },

  mounted() {
    this.init();
  },
}
</script>