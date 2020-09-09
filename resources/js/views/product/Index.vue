<template>
  <TheIndex
    ref="index"
    :title="$t('product.title')"
    :link-to-new="{name: 'product.new'}"
    :on-submit="onSubmit"
  >
    <TheIndexSearchResult :columns="columns">
      <tr v-for="product in getPageProducts" v-bind:key="product.id">
        <td class="align-middle">
          {{ product.name }}
        </td>
        <td class="align-middle">
          {{ product.summary }}
        </td>
        <td class="align-middle text-right">
          <ButtonEdit
            :link-to="{name: 'product.edit', params: {productId: product.id}}"
          />
          <ButtonDelete
            @click="destroy(product)"
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
      paginate: {
        per: 10,
        current: 1,
      },

      products: [],
    }
  },

  methods: {
    search() {
      this.$refs.index.submit();
    },

    onSubmit(keyword = "") {
      axios.get('/api/product/search', {
        params: {
          keyword: keyword
        }
      }).then(res => {
        this.products = res.data;
      });
    },

    destroy(product) {
      if (confirm(this.$t('common.message.confirm_delete', [product.name]))) {
        axios.delete('/api/product/' + product.id).then(res => {
          this.search();
        });
      }
    },

    onClickPaginate(pageNum) {
      this.paginate.current = pageNum;
    },
  },

  computed: {
    columns() {
      return [
        this.$t('product.name'),
        this.$t('product.summary'),
        "",
      ];
    },
    
    getPageProducts() {
      let current = this.paginate.current * this.paginate.per;
      let start = current - this.paginate.per;
      return this.products.slice(start, current);
    },

    getPageCount() {
      return Math.ceil(this.products.length / this.paginate.per);
    },
  },

  mounted() {
    this.search();
  },
}
</script>