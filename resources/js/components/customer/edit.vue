<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <router-link :to="{name: 'customer.index'}">
        <button class="btn btn-outline-primary">
          <i class="fas fa-angle-left"></i> 戻る
        </button>
      </router-link>
    </div>
    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">取引先編集</div>
      <div class="card-body">
        <form @submit.prevent="updateCustomer">
          <div class="form-group">
            <label for="name">名称</label>
            <input id="name" class="form-control" type="text" v-model="customer.name" :class="{ 'is-invalid': errors.name }">
            <div class="invalid-feedback" v-for="error in errors.name" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input id="postal_code" class="form-control" type="text" v-model="customer.postal_code" :class="{ 'is-invalid': errors.postal_code }">
            <div class="invalid-feedback" v-for="error in errors.postal_code" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="address">住所・宛先</label>
            <textarea id="address" class="form-control" type="text" rows="3" v-model="customer.address" :class="{ 'is-invalid': errors.address }"/>
            <div class="invalid-feedback" v-for="error in errors.address" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="tel_no">電話番号</label>
            <input id="tel_no" class="form-control" type="text" v-model="customer.tel_no" :class="{ 'is-invalid': errors.tel_no }">
            <div class="invalid-feedback" v-for="error in errors.tel_no" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="text-center">
            <button class="btn btn-primary" type="submit">保存</button>
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