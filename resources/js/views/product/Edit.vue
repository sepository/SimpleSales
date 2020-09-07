<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <BackButton :route="'product.index'"></BackButton>
    </div>

    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('product.edit') }}
      </div>
      <div class="card-body">
        <form @submit.prevent="updateProduct">
          <BaseText id="name" :title="$t('product.name')" v-model="product.name" :errors="errors.name"></BaseText>
          <div class="form-row">
            <BaseNumber id="price" :title="$t('product.price')" v-model.number="product.price" :errors="errors.price" form-group-class="col-md-6"></BaseNumber>
            <BaseSelect id="unit" :title="$t('product.unit')" v-model.number="product.unit_id" :errors="errors.unit_id" form-group-class="col-md-6" :items="units" item-value="id" item-caption="name"></BaseSelect>
          </div>
          <BaseTextArea id="summary" :title="$t('product.summary')" v-model="product.summary" :errors="errors.summary"></BaseTextArea>
          <div class="text-center">
            <button class="btn btn-primary" type="submit">
              {{ $t('common.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    productId: String
  },

  data() {
    return {
      product: {},
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

    getProduct() {
      axios.get('/api/product/' + this.productId).then(res => {
        this.product = res.data;
      });
    },

    updateProduct() {
      axios.put('/api/product/' + this.productId, this.product).then(res => {
        this.$router.push({name: 'product.index'});
      })
      .catch(ex => {
        this.errors = ex.response.data.errors;
      });
    }
  },

  mounted() {
    this.getUnits();
    this.getProduct();
  }
}
</script>