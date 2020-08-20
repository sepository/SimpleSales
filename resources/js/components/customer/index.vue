<template>
  <div>
    <h1>取引先</h1>
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <form class="form-inline" @submit.prevent="searchCustomer">
          <div class="form-group">
            <input class="form-control ml-1" id="keyword"  type="text" v-model="keyword">
            <button class="btn btn-primary m-1" type="submit">検索</button>
          </div>
        </form>
      </div>
      <div class="col-md-2 col-lg-2 text-right">
        <router-link :to="{name: 'customer.new'}">
          <button class="btn btn-primary m-1">新規</button>
        </router-link>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">名称</th>
              <th scope="col">住所</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="customer in customers" v-bind:key="customer.id">
              <td>{{ customer.name }}</td>
              <td>{{ customer.address }}</td>
              <td>
                <button class="btn btn-primary mx-1">編集</button>
                <button class="btn btn-danger mx-1">削除</button>
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
    axios.get('/api/customer').then(res => {
      this.customers = res.data;
    });
  },
  methods: {
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
    }
  }
}
</script>