<template>
  <EditForm
    :title="$t('product.new')"
    :link-to-back="{name: 'product.index'}"
    :on-submit="create"
    :submit-text="$t('common.save')"
  >
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
  </EditForm>
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
    init() {
      axios.get('/api/unit').then(res => {
        this.units = res.data;
      });
    },

    create() {
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
    this.init();
  }
}
</script>