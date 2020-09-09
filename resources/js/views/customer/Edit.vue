<template>
  <EditForm
    :title="$t('customer.edit')"
    :link-to-back="{name: 'customer.index'}"
    :on-submit="update"
    :submit-text="$t('common.save')"
  >
    <BaseText
      id="name" 
      v-model="customer.name"
      :title="$t('customer.name')"
      :errors="errors.name"
    />
    <BaseText
      id="postal_code"
      v-model="customer.postal_code"
      :title="$t('customer.postal_code')"
      :errors="errors.postal_code"
    />
    <BaseTextArea
      id="address"
      v-model="customer.address"
      :title="$t('customer.address')"
      :errors="errors.address"
    />
    <BaseText
      id="tel_no"
      v-model="customer.tel_no"
      :title="$t('customer.tel_no')"
      :errors="errors.tel_no"
    />
  </EditForm>
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
    init() {
      axios.get('/api/customer/' + this.customerId).then(res => {
        this.customer = res.data;
      });
    },

    update() {
      axios.put('/api/customer/' + this.customerId, this.customer).then(res => {
        this.$router.push({name: 'customer.index'});
      })
      .catch(ex => {
        this.errors = ex.response.data.errors;
      });
    },
  },

  mounted() {
    this.init();
  }
}
</script>