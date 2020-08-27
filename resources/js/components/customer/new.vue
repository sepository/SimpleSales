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
      <div class="card-header bg-secondary text-light text-center">取引先登録</div>
      <div class="card-body">
        <form @submit.prevent="createCustomer">
          <div class="form-group">
            <label for="name">名称</label>
            <input id="name" class="form-control" type="text" v-model="name" :class="{ 'is-invalid': errors.name }">
            <div class="invalid-feedback" v-for="error in errors.name" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input id="postal_code" class="form-control" type="text" v-model="postal_code" :class="{ 'is-invalid': errors.postal_code }">
            <div class="invalid-feedback" v-for="error in errors.postal_code" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="address">住所・宛先</label>
            <textarea id="address" class="form-control" type="text" rows="3" v-model="address"  :class="{ 'is-invalid': errors.address }"/>
            <div class="invalid-feedback" v-for="error in errors.address" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="tel_no">電話番号</label>
            <input id="tel_no" class="form-control" type="text" v-model="tel_no" :class="{ 'is-invalid': errors.tel_no }">
            <div class="invalid-feedback" v-for="error in errors.tel_no" v-bind:key="error">
              {{ error }}
            </div>
          </div>
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