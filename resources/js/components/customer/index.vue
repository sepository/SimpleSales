<template>
  <div>
    <div class="d-flex bd-highlight">
      <h1 class="bd-highlight mx-auto">取引先</h1>
    </div>
    <div class="d-flex bd-highlight">
      <div class="bd-highlight">
        <form class="form-inline" @submit.prevent="searchCustomer">
          <label class="sr-only" for="keyword">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">検索</div>
            </div>
            <input class="form-control" id="keyword" type="text" v-model="keyword">
          </div>
        </form>
      </div>
      <div class="bd-highlight ml-auto">
        <router-link :to="{name: 'customer.new'}" >
          <button class="btn btn-primary m-1">新規</button>
        </router-link>
      </div>
    </div>
    <div class="card p-0 mt-2">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr class="table-secondary">
              <th scope="col" class="border-0">名称</th>
              <th scope="col" class="border-0">住所</th>
              <th scope="col" class="border-0"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="customer in customers" v-bind:key="customer.id">
              <td class="align-middle">{{ customer.name }}</td>
              <td class="align-middle">{{ customer.address }}</td>
              <td class="text-right">
                <router-link :to="{name: 'customer.edit', params: {customerId: customer.id}}">
                  <button class="btn btn-primary mx-1">編集</button>
                </router-link>
                <button class="btn btn-danger mx-1" @click="confirmDeleteCustomer(customer.id, customer.name)">削除</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      customers: [],
      keyword: ""
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
      if (confirm(name + 'を削除してもよろしいでしょうか？')) {
        this.deleteCustomer(id);
      }
    }
  }
}
</script>