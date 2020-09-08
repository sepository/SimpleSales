<template>
  <div class="form-group" :class="formGroupClass">
    <label :for="id">
      {{ title }}
    </label>

    <DatePicker
      :id="id"
      :value="value"
      :format="format"
      :input-class="inputClass"
      bootstrap-styling
      typeable
      @input="onInput($event)"
    />

    <div
      v-for="error in errors"
      v-bind:key="error"
      class="text-danger"
      style="font-size: 80%"
    >
      {{ error }}
    </div>
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
      type: Date
    },

    errors: {
      type: Array
    },

    format: {
      type: String,
      default: "yyyy/MM/dd"
    },

    formGroupClass: {
      type: String,
      default: ""
    }
  },

  computed: {
    inputClass() {
      return {
        'is-invalid': this.errors
      }
    },
  },

  methods: {
    onInput(value) {
      this.$emit('input', value);
      this.$emit('input-after');
    },
  },
}
</script>