<template>
  <TheIndex
    ref="index"
    :title="$t('invoice.title')"
    :filter-enabled="true"
    :link-to-new="{name: 'invoice.new'}"
    :on-submit="onSubmit"
  >
    <template v-slot:filters>
      <TheIndexFilterItem>
        <BaseSelect
          id="customer_id"
          v-model.number="filter.customer_id"
          :title="$t('invoice.customer')"
          :items="customers"
          item-value="id"
          item-caption="name"
        />
      </TheIndexFilterItem>

      <TheIndexFilterItem>
        <DatePickerFromTo
          id="invoice_date"
          v-model="filter.invoice_date"
          :title="$t('invoice.invoice_date')"
        />
      </TheIndexFilterItem>

      <TheIndexFilterItem>
        <DatePickerFromTo
          id="payment_due_date"
          v-model="filter.payment_due_date"
          :title="$t('invoice.payment_due_date')"
        />
      </TheIndexFilterItem>
    </template>

    <TheIndexSearchResult :columns="columns">
      <tr v-for="invoice in getPageInvoices" v-bind:key="invoice.id">
        <td class="align-middle">
          {{ invoice.customer.name }}
        </td>
        <td class="align-middle">
          {{ invoice.invoice_no }}
        </td>
        <td class="align-middle">
          {{ dateFormat(invoice.invoice_date) }}
        </td>
        <td class="align-middle">
          {{ dateFormat(invoice.payment_due_date) }}
        </td>
        <td class="align-middle text-right">
          <ButtonEdit
            :link-to="{name: 'invoice.edit', params: {invoiceId: String(invoice.id)}}"
          />
        </td>
      </tr>
    </TheIndexSearchResult>

    <template v-slot:paginate>
      <BasePaginate :pageCount="getPageCount" v-bind:currentPage.sync="paginate.current"/>
    </template>
  </TheIndex>
</template>

<script>
export default {
  data() {
    return {
      filter: {
        customer_id: null,
        invoice_date: {
          from: null,
          to: null,
        },
        payment_due_date: {
          from: null,
          to: null,
        },
      },

      paginate: {
        per: 10,
        current: 1,
      },

      invoices: [],
      customers: [],
    }
  },

  methods: {
    search() {
      this.$refs.index.submit();
    },

    onSubmit(keyword = "") {
      axios.get('/api/invoice', {
        params: {
          keyword:                keyword,
          customer_id:            this.filter.customer_id,
          invoice_date_from:      this.dateFormat(this.filter.invoice_date.from),
          invoice_date_to:        this.dateFormat(this.filter.invoice_date.to),
          payment_due_date_from:  this.dateFormat(this.filter.payment_due_date.from),
          payment_due_date_to:    this.dateFormat(this.filter.payment_due_date.to),
        }
      })
      .then(res => {
        this.invoices = res.data;
      });
    },

    getCustomers() {
      axios.get('/api/customer').then(res => {
        this.customers = res.data;
      });
    },

    onClickPaginate(pageNum) {
      this.paginate.current = pageNum;
    },
  },

  computed: {
    columns() {
      return [
        this.$t('invoice.customer'),
        this.$t('invoice.invoice_no'),
        this.$t('invoice.invoice_date'),
        this.$t('invoice.payment_due_date'),
        "",
      ];
    },

    getPageInvoices() {
      let current = this.paginate.current * this.paginate.per;
      let start = current - this.paginate.per;
      return this.invoices.slice(start, current);
    },

    getPageCount() {
      return Math.ceil(this.invoices.length / this.paginate.per);
    },
  },

  mounted() {
    this.search();
    this.getCustomers();
  },
}
</script>