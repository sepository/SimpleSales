<template>
  <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <BackButton :route="'product.index'"/>
    </div>

    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('product.new') }}
      </div>
      <div class="card-body">
        <form @submit.prevent="createProduct">
          <BaseText
            id="name"
            v-model="name"
            :title="$t('product.name')"
            :errors="errors.name"
          />
          <div class="form-row">
            <BaseNumber
              id="price"
              v-model.number="price"
              :title="$t('product.price')"
              :errors="errors.price"
              form-group-class="col-md-6"
            />
            <BaseSelect
              id="unit"
              v-model.number="unit_id"
              :title="$t('product.unit')"
              :errors="errors.unit_id"
              :items="units"
              item-value="id"
              item-caption="name"
              form-group-class="col-md-6"
            />
          </div>
          <BaseTextArea
            id="summary"
            v-model="summary"
            :title="$t('product.summary')"
            :errors="errors.summary"
          />
          <div class="text-center">
            <button type="submit" class="btn btn-primary">
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