<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <BackButton :route="'customer.index'"></BackButton>
    </div>
    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('customer.edit') }}
      </div>
      <div class="card-body">
        <form @submit.prevent="updateCustomer">
          <BaseText id="name" :title="$t('customer.name')" v-model="customer.name" :errors="errors.name"></BaseText>
          <BaseText id="postal_code" :title="$t('customer.postal_code')" v-model="customer.postal_code" :errors="errors.postal_code"></BaseText>
          <BaseTextArea id="address" :title="$t('customer.address')" v-model="customer.address" :errors="errors.address"></BaseTextArea>
          <BaseText id="tel_no" :title="$t('customer.tel_no')" v-model="customer.tel_no" :errors="errors.tel_no"></BaseText>
          <div class="text-center">
            <button class="btn btn-primary" type="submit">
              {{ $t('common.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    customerId: String
  },

  data() {
    return {
      customer: {},
      errors: []
    }
  },

  methods: {
    getCustomer() {
      axios.get('/api/customer/' + this.customerId).then(res => {
        this.customer = res.data;
      });
    },

    updateCustomer() {
      axios.put('/api/customer/' + this.customerId, this.customer).then(res => {
        this.$router.push({name: 'customer.index'});
      })
      .catch(ex => {
        this.errors = ex.response.data.errors;
      });
    }
  },

  mounted() {
    this.getCustomer();
  }
}
</script>