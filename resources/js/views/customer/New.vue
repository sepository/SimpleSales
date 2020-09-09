<template>
  <EditForm
    :title="$t('customer.new')"
    :link-to-back="{name: 'customer.index'}"
    :on-submit="create"
    :submit-text="$t('common.regist')"
  >
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
  </EditForm>
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
    create() {
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