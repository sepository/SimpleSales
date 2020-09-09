<template>
  <EditForm
    :title="$t('invoice.new')"
    :link-to-back="{name: 'invoice.index'}"
    :on-submit="create"
    :submit-text="$t('common.regist')"
  >
    <BaseSelect
      id="customer_id"
      v-model="customer_id"
      :title="$t('invoice.customer')"
      :errors="errors.customer_id"
      :items="customers"
      item-value="id"
      item-caption="name"
    />
    <BaseText
      id="invoice_no"
      v-model="invoice_no"
      :title="$t('invoice.invoice_no')"
      :errors="errors.invoice_no"
    />
    <div class="form-row">
      <BaseDatePicker
        id="invoice_date"
        v-model="invoice_date"
        :title="$t('invoice.invoice_date')"
        :errors="errors.invoice_date"
        form-group-class="col-md-6"
      />
      <BaseDatePicker
        id="payment_due_date"
        v-model="payment_due_date"
        :title="$t('invoice.payment_due_date')"
        :errors="errors.payment_due_date"
        form-group-class="col-md-6"
      />
    </div>
    <BaseTextArea
      id="remarks"
      v-model="remarks"
      :title="$t('invoice.remarks')"
      :errors="errors.remarks"
    />
  </EditForm>
</template>

<script>
export default {
  data() {
    return {
      customer_id: null,
      invoice_no: "",
      invoice_date: new Date,
      payment_due_date: null,
      remarks: "",

      customers: [],
      errors: [],
    }
  },

  methods: {
    create() {
      axios.post('/api/invoice', {
        customer_id:      this.customer_id,
        invoice_no:       this.invoice_no,
        invoice_date:     this.$moment(this.invoice_date).format('YYYY-MM-DD'),
        payment_due_date: this.$moment(this.payment_due_date).format('YYYY-MM-DD'),
        remarks:          this.remarks,
      })
      .then(res => {
        this.$router.push({name: 'invoice.index'});
      })
      .catch(ex => {
        this.errors = ex.response.data.errors;
      });
    },

    getCustomers() {
      axios.get('/api/customer')
        .then(res => {
          this.customers = res.data;
        });
    },
  },

  mounted() {
    this.getCustomers();
  },
}
</script>