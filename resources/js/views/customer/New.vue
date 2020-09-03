<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <BackButton :route="'customer.index'"></BackButton>
    </div>
    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">取引先登録</div>
      <div class="card-body">
        <form @submit.prevent="createCustomer">
          <BaseText id="name" title="名称" v-model="name" :errors="errors.name"></BaseText>
          <BaseText id="postal_code" title="郵便番号" v-model="postal_code" :errors="errors.postal_code"></BaseText>
          <BaseTextArea id="address" title="住所・宛先" v-model="address" :errors="errors.address"></BaseTextArea>
          <BaseText id="tel_no" title="電話番号" v-model="tel_no" :errors="errors.tel_no"></BaseText>
          <div class="text-center">
            <button class="btn btn-primary" type="submit">登録</button>
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