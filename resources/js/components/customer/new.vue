<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 text-left">
        <router-link :to="{name: 'customer.index'}">
          <i class="fas fa-angle-left"></i> 戻る
        </router-link>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">取引先登録</div>
          <div class="card-body">
            <form @submit.prevent="createCustomer">
              <div class="form-group text-left">
                <label for="name">名称</label>
                <input id="name" class="form-control" type="text" v-model="name">
              </div>
              <div class="form-group text-left">
                <label for="postal_code">郵便番号</label>
                <input id="postal_code" class="form-control" type="text" v-model="postal_code">
              </div>
              <div class="form-group text-left">
                <label for="address">住所・宛先</label>
                <textarea id="address" class="form-control" type="text" rows="3" v-model="address"/>
              </div>
              <div class="form-group text-left">
                <label for="tel_no">電話番号</label>
                <input id="tel_no" class="form-control" type="text" v-model="tel_no">
              </div>
              <button class="btn btn-primary" type="submit">登録</button>
            </form>
          </div>
        </div>
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
      tel_no: ""
    }
  },
  methods: {
    createCustomer() {
      axios.get('/api/customer', {
        name: this.name,
        postal_code: this.postal_code,
        address: this.address,
        tel_no: this.tel_no
      }).then(res => {
        this.$router.push({name: 'customer.index'});
      })
    }
  }
}
</script>