<template>
  <div>
    <div class="d-flex bd-highlight">
      <h1 class="bd-highlight mx-auto">
        {{ $t('customer.title') }}
      </h1>
    </div>

    <div class="d-flex bd-highlight">
      <div class="bd-highlight">
        <form class="form-inline" @submit.prevent="searchCustomer">
          <label class="sr-only" for="keyword">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                {{ $t('common.search') }}
              </div>
            </div>
            <input class="form-control" id="keyword" type="text" v-model="keyword">
          </div>
        </form>
      </div>
      <div class="bd-highlight ml-auto">
        <router-link :to="{name: 'customer.new'}" >
          <button class="btn btn-primary m-1">
            {{ $t('common.new') }}
          </button>
        </router-link>
      </div>
    </div>

    <div class="card p-0 mt-2">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr class="table-secondary">
              <th scope="col" class="border-0">
                {{ $t('customer.name') }}
              </th>
              <th scope="col" class="border-0">
                {{ $t('customer.address') }}
              </th>
              <th scope="col" class="border-0"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="customer in getPageCustomers" v-bind:key="customer.id">
              <td class="align-middle">{{ customer.name }}</td>
              <td class="align-middle">{{ customer.address }}</td>
              <td class="text-right">
                <router-link :to="{name: 'customer.edit', params: {customerId: customer.id}}">
                  <button class="btn btn-primary mx-1">
                    {{ $t('common.edit') }}
                  </button>
                </router-link>
                <button class="btn btn-danger mx-1" @click="confirmDeleteCustomer(customer.id, customer.name)">
                  {{ $t('common.delete') }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex bd-highlight mt-3">
      <div class="bd-highlight ml-auto">
        <BasePaginate :pageCount="getPageCount" v-bind:currentPage.sync="currentPage"></BasePaginate>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      customers: [],
      keyword: "",
      perPage: 10,
      currentPage: 1
    }
  },

  mounted() {
    this.getCustomer();
  },

  methods: {
    getCustomer() {
      axios.get('/api/customer').then(res => {
        this.customers = res.data;
      });
    },

    searchCustomer() {
      axios.get('/api/customer/search', {
        params: { 
          keyword: this.keyword
        }
      })
      .then(res => {
        console.log(res);
        this.customers = res.data;
      })
    },

    deleteCustomer(id) {
      axios.delete('/api/customer/' + id).then(res => {
        this.getCustomer();
      });
    },

    confirmDeleteCustomer(id, name) {
      if (confirm(this.$t('common.message.confirm_delete', [name]))) {
        this.deleteCustomer(id);
      }
    },

    clickPaginate(pageNum) {
      this.currentPage = Number(pageNum);
    }
  },

  computed: {
    getPageCustomers() {
      let current = this.currentPage * this.perPage;
      let start = current - this.perPage;
      return this.customers.slice(start, current);
    },

    getPageCount() {
      return Math.ceil(this.customers.length / this.perPage);
    }
  }
}
</script>