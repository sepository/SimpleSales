<template>
  <div>
    <div class="d-flex bd-highlight">
      <h1 class="bd-highlight mx-auto">商品</h1>
    </div>

    <div class="d-flex bd-highlight">
      <div class="bd-highlight">
        <form class="form-inline" @submit.prevent="searchProducts">
          <label class="sr-only" for="keyword">Product</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">検索</div>
            </div>
            <input class="form-control" id="keyword" type="text" v-model="keyword">
          </div>
        </form>
      </div>
      <div class="bd-highlight ml-auto">
        <router-link :to="{name: 'product.new'}">
          <button class="btn btn-primary m-1">新規</button>
        </router-link>
      </div>
    </div>

    <div class="card p-0 mt-2">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr class="table-secondary">
              <td scope="col" class="border-0">名称</td>
              <td scope="col" class="border-0">概要</td>
              <td scope="col" class="border-0"></td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" v-bind:key="product.id">
              <td class="align-middle">{{ product.name }}</td>
              <td class="align-middle">{{ product.summary }}</td>
              <td class="align-middle text-right">
                <router-link :to="{name: 'product.edit', params: {productId: product.id}}">
                  <button class="btn btn-primary mx-1">編集</button>
                </router-link>
                <button class="btn btn-danger mx-1" @click="confirmDeleteProduct(product.id, product.name)">削除</button>
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
      products: [],
      keyword: ""
    }
  },

  methods: {
    getProducts() {
      axios.get('/api/product').then(res => {
        this.products = res.data;
      });
    },

    searchProducts() {
      axios.get('/api/product/search', {
        params: {
          keyword: this.keyword
        }
      }).then(res => {
        this.products = res.data;
      });
    },

    deleteProduct(id) {
      axios.delete('/api/product/' + id).then(res => {
        this.getProducts();
      })
    },

    confirmDeleteProduct(id, name) {
      if (confirm(name + 'を削除してもよろしいでしょうか？')) {
        this.deleteProduct(id);
      }
    }
  },

  mounted() {
    this.getProducts();
  }
}
</script>