<template>
  <div class="d-flex">
    <BaseDatePicker
      :id="idFrom"
      :value="value.from"
      :title="title"
      @input="onInputFrom($event)"
    />

    <div class="form-group align-self-end">
      <span class="form-control border-0">~</span>
    </div>

    <BaseDatePicker
      :id="idTo"
      :value="value.to"
      form-group-class="align-self-end"
      @input="onInputTo($event)"
    />
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String
    },

    title: {
      type: String
    },

    value: {
      type: Object,
      default: {
        from: null,
        to: null,
      }
    },
  },

  computed: {
    idFrom() {
      return this.id + "-from";
    },

    idTo() {
      return this.id + "-to";
    },
  },

  methods: {
    onInputFrom(value) {
      this.value.from = value;
      this.$emit('input', this.value);
    },

    onInputTo(value) {
      this.value.to = value;
      this.$emit('input', this.value);
    },
  },
}
</script>