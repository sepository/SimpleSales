<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <BackButton :route="'customer.index'"/>
    </div>
    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('customer.new') }}
      </div>
      <div class="card-body">
        <form @submit.prevent="createCustomer">
          <BaseText
            id="name"
            v-model="name"
            :title="$t('customer.name')"
            :errors="errors.name"
          />
          <BaseText
            id="postal_code"
            v-model="postal_code"
            :title="$t('customer.postal_code')"
            :errors="errors.postal_code"
          />
          <BaseTextArea
            id="address"
            v-model="address"
            :title="$t('customer.address')"
            :errors="errors.address"
          />
          <BaseText
            id="tel_no"
            v-model="tel_no"
            :title="$t('customer.tel_no')"
            :errors="errors.tel_no"
          />
          <div class="text-center">
            <button type="submit" class="btn btn-primary">
              {{ $t('common.regist') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      postal_code: "",
      address: "",
      tel_no: "",
      errors: []
    }
  },

  methods: {
    createCustomer() {
      axios.post('/api/customer', {
        name: this.name,
        postal_code: this.postal_code,
        address: this.address,
        tel_no: this.tel_no
      }).then(res => {
        this.$router.push({name: 'customer.index'});
      }).catch(ex => {
        this.errors = ex.response.data.errors;
      });
    }
  }
}
</script>