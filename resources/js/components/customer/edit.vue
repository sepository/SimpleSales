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
            <form @submit.prevent="updateCustomer">
              <div class="form-group text-left">
                <label for="name">名称</label>
                <input id="name" class="form-control" type="text" v-model="customer.name">
                <div class="alert alert-danger" role="alert" v-if="errors.name">
                  {{ errors.name[0] }}
                </div>
              </div>
              <div class="form-group text-left">
                <label for="postal_code">郵便番号</label>
                <input id="postal_code" class="form-control" type="text" v-model="customer.postal_code">
              </div>
              <div class="form-group text-left">
                <label for="address">住所・宛先</label>
                <textarea id="address" class="form-control" type="text" rows="3" v-model="customer.address"/>
              </div>
              <div class="form-group text-left">
                <label for="tel_no">電話番号</label>
                <input id="tel_no" class="form-control" type="text" v-model="customer.tel_no">
              </div>
              <button class="btn btn-primary" type="submit">保存</button>
            </form>
          </div>
        </div>
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