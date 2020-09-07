<template>
  <div>
    <div class="d-flex bd-highlight">
      <h1 class="bd-highlight mx-auto">
        {{ $t('product.title') }}
      </h1>
    </div>

    <div class="d-flex bd-highlight">
      <div class="bd-highlight">
        <form class="form-inline" @submit.prevent="searchProducts">
          <label class="sr-only" for="keyword">Product</label>
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
        <router-link :to="{name: 'product.new'}">
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
                {{ $t('product.name') }}
              </th>
              <th scope="col" class="border-0">
                {{ $t('product.summary') }}
              </th>
              <th scope="col" class="border-0"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in getPageProducts" v-bind:key="product.id">
              <td class="align-middle">{{ product.name }}</td>
              <td class="align-middle">{{ product.summary }}</td>
              <td class="align-middle text-right">
                <router-link :to="{name: 'product.edit', params: {productId: product.id}}">
                  <button class="btn btn-primary mx-1">
                    {{ $t('common.edit') }}
                  </button>
                </router-link>
                <button class="btn btn-danger mx-1" @click="confirmDeleteProduct(product.id, product.name)">
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
        <BasePaginate :pageCount="getPageCount" v-bind:currentPage.sync="currentPage"/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: [],
      keyword: "",
      perPage: 10,
      currentPage: 1
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
      if (confirm(this.$t('common.message.confirm_delete', [name]))) {
        this.deleteProduct(id);
      }
    },

    clickPaginate(pageNum) {
      this.currentPage = Number(pageNum);
    }
  },

  computed: {
    getPageProducts() {
      let current = this.currentPage * this.perPage;
      let start = current - this.perPage;
      return this.products.slice(start, current);
    },

    getPageCount() {
      return Math.ceil(this.products.length / this.perPage);
    }
  },

  mounted() {
    this.getProducts();
  }
}
</script>