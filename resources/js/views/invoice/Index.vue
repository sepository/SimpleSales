<template>
  <div>
    <div class="d-flex bd-hightlight">
      <h1 class="bd-hightlight mx-auto">
        {{ $t('invoice.title') }}
      </h1>
    </div>

    <div class="d-flex bd-highlight">
      <div class="bd-highlight">
        <form class="form-inline" @submit.prevent="search">
          <label class="sr-only" for="keyword">Keyword</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <button 
                type="button"
                class="btn btn-outline-secondary dropdown-toggle"
                data-toggle="collapse"
                data-target="#collapseFilter"
                aria-expanded="false"
                aria-controls="collapseFilter"
              >
                {{ $t('common.filter') }}
              </button>
            </div>
            <input
              id="keyword"
              v-model="filter.keyword"
              type="text"
              class="form-control"
            >
          </div>
        </form>
      </div>

      <div class="bd-highlight ml-auto">
        <router-link :to="{name: 'invoice.new'}">
          <button class="btn btn-primary m-1">
            {{ $t('common.new') }}
          </button>
        </router-link>
      </div>
    </div>

    <div id="collapseFilter" class="collapse">
      <div class="card card-body">
        <div class="row">
          <div class="col-md-4">
            <BaseSelect
              id="customer_id"
              v-model.number="filter.customer_id"
              :title="$t('invoice.customer')"
              :items="customers"
              item-value="id"
              item-caption="name"
              @change-after="search"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="card p-0 mt-2">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr class="table-secondary">
              <th scope="col" class="border-0">
                {{ $t('invoice.customer') }}
              </th>
              <th scope="col" class="border-0">
                {{ $t('invoice.invoice_no') }}
              </th>
              <th scope="col" class="border-0">
                {{ $t('invoice.invoice_date') }}
              </th>
              <th scope="col" class="border-0">
                {{ $t('invoice.payment_due_date') }}
              </th>
              <th scope="col" class="border-0"></th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="invoice in getPageInvoices" v-bind:key="invoice.id">
              <td class="align-middle">
                {{ invoice.customer.name }}
              </td>
              <td class="align-middle">
                {{ invoice.invoice_no }}
              </td>
              <td class="align-middle">
                {{ $moment(invoice.invoice_date).format('YYYY/MM/DD') }}
              </td>
              <td class="align-middle">
                {{ $moment(invoice.payment_due_date).format('YYYY/MM/DD') }}
              </td>
              <td class="align-middle text-right">
                <router-link to="#">
                  <button class="btn btn-primary mx-1">
                    {{ $t('common.edit') }}
                  </button>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex bd-highlight mt-3">
      <div class="bd-highlight ml-auto">
        <BasePaginate :pageCount="getPageCount" v-bind:currentPage.sync="currentPage"/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filter: {
        keyword: "",
        customer_id: null,
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
      axios.get('/api/invoice', {
        params: {
          keyword:      this.filter.keyword,
          customer_id:  this.filter.customer_id,
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