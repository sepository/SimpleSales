<template>
  <EditForm
    :title="$t('product.edit')"
    :link-to-back="{name: 'product.index'}"
    :on-submit="update"
    :submit-text="$t('common.save')"
  >
    <BaseText
      id="name"
      v-model="product.name"
      :title="$t('product.name')"
      :errors="errors.name"
    />
    <div class="form-row">
      <BaseNumber
        id="price"
        v-model.number="product.price" 
        :title="$t('product.price')"
        :errors="errors.price"
        form-group-class="col-md-6"
      />
      <BaseSelect
        id="unit"
        v-model.number="product.unit_id"
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
      v-model="product.summary"
      :title="$t('product.summary')"
      :errors="errors.summary"
    />
  </EditForm>
  <!-- <div class="container">
    <div class="mx-auto mb-2" style="max-width: 600px">
      <BackButton :route="'product.index'"/>
    </div>

    <div class="card mx-auto" style="max-width: 600px">
      <div class="card-header bg-secondary text-light text-center">
        {{  }}
      </div>
      <div class="card-body">
        <form @submit.prevent="updateProduct">
          <div class="text-center">
            <button type="submit" class="btn btn-primary">
              {{ $t('common.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div> -->
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
    init() {
      axios.get('/api/unit').then(res => {
        this.units = res.data;
      });

      axios.get('/api/product/' + this.productId).then(res => {
        this.product = res.data;
      });
    },

    update() {
      axios.put('/api/product/' + this.productId, this.product).then(res => {
        this.$router.push({name: 'product.index'});
      })
      .catch(ex => {
        this.errors = ex.response.data.errors;
      });
    }
  },

  mounted() {
    this.init();
  }
}
</script>