<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <BackButton :route="'product.index'"></BackButton>
    </div>

    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('product.new') }}
      </div>
      <div class="card-body">
        <form @submit.prevent="createProduct">
          <BaseText id="name" :title="$t('product.name')" v-model="name" :errors="errors.name"></BaseText>
          <div class="form-row">
            <BaseNumber id="price" :title="$t('product.price')" v-model.number="price" :errors="errors.price" form-group-class="col-md-6"></BaseNumber>
            <BaseSelect id="unit" :title="$t('product.unit')" v-model.number="unit_id" :errors="errors.unit_id" form-group-class="col-md-6" :items="units" item-value="id" item-caption="name"></BaseSelect>
          </div>
          <BaseTextArea id="summary" :title="$t('product.summary')" v-model="summary" :errors="errors.summary"></BaseTextArea>
          <div class="text-center">
            <button class="btn btn-primary" type="submit">
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