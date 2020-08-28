<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <router-link :to="{name: 'product.index'}">
        <button class="btn btn-outline-primary">
          <i class="fas fa-angle-left"></i> 戻る
        </button>
      </router-link>
    </div>

    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">商品登録</div>
      <div class="card-body">
        <form @submit.prevent="createProduct">
          <div class="form-group">
            <label for="name">名称</label>
            <input id="name" class="form-control" type="text" v-model="name" :class="{'is-invalid': errors.name}">
            <div class="invalid-feedback" v-for="error in errors.name" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="price">単価</label>
              <input id="price" class="form-control" type="number" v-model.number="price" :class="{'is-invalid': errors.price}">
              <div class="invalid-feedback" v-for="error in errors.price" v-bind:key="error">
                {{ error }}
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="unit">単位</label>
              <select id="unit" class="form-control" v-model.number="unit_id" :class="{'is-invalid': errors.unit_id}">
                <option v-for="unit in units" v-bind:key="unit.id" v-bind:value="unit.id">
                  {{ unit.name }}
                </option>
              </select>
              <div class="invalid-feedback" v-for="error in errors.unit_id" v-bind:key="error">
                {{ error }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="summary">概要</label>
            <textarea id="summary" class="form-control" type="text" rows="3" v-model="summary"  :class="{ 'is-invalid': errors.summary }"/>
            <div class="invalid-feedback" v-for="error in errors.summary" v-bind:key="error">
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
      price: 0,
      unit_id: null,
      summary: "",
      units: [],
      errors: []
    }
  },

  methods: {
    getUnits() {
      axios.get('/api/unit').then(res => {
        this.units = res.data;
      });
    },

    createProduct() {
      axios.post('/api/product', {
        name: this.name,
        price: this.price,
        unit_id: this.unit_id,
        summary: this.summary
      }).then(res => {
        this.$router.push({name: 'product.index'});
      }).catch(ex => {
        this.errors = ex.response.data.errors;
      });
    }
  },

  mounted() {
    this.getUnits();
  }
}
</script>