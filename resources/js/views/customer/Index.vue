<template>
  <TheIndex
    ref="index"
    :title="$t('customer.title')"
    :link-to-new="{name: 'customer.new'}"
    :on-submit="onSubmit"
  >
    <TheIndexSearchResult :columns="columns"> 
      <tr v-for="customer in getPageCustomers" v-bind:key="customer.id">
        <td class="align-middle">
          {{ customer.name }}
        </td>
        <td class="align-middle">
          {{ customer.address }}
        </td>
        <td class="align-middle text-right">
          <ButtonEdit 
            :link-to="{name: 'customer.edit', params: {customerId: customer.id}}"
          />
          <ButtonDelete 
            @click="destroy(customer)"
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

      customers: [],
    }
  },

  methods: {
    search() {
      this.$refs.index.submit();
    },

    onSubmit(keyword = "") {
      axios.get('/api/customer/search', {
        params: { 
          keyword: keyword
        }
      })
      .then(res => {
        this.customers = res.data;
      });
    },

    destroy(customer) {
      if (confirm(this.$t('common.message.confirm_delete', [customer.name]))) {
        axios.delete('/api/customer/' + customer.id).then(res => {
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
        this.$t('customer.name'),
        this.$t('customer.address'),
        ""
      ];
    },

    getPageCustomers() {
      let current = this.paginate.current * this.paginate.per;
      let start = current - this.paginate.per;
      return this.customers.slice(start, current);
    },

    getPageCount() {
      return Math.ceil(this.customers.length / this.paginate.per);
    },
  },

  mounted() {
    this.search();
  },
}
</script>