<template>
  <div class="form-group" :class="formGroupClass">
    <label
      v-if="title"
      :for="id"
    >
      {{ title }}
    </label>
    <input
      class="form-control"
      type="number"
      :id="id"
      :value="value"
      :disabled="disabled"
      :class="inputClass"
      @input="onInput($event.target.value)">
    <div class="invalid-feedback" v-for="error in errors" v-bind:key="error">
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
      type: [Number, String],
      validator: function (value) {
        return !isNaN(value);
      }    
    },

    disabled: {
      type: Boolean,
      default: false
    },

    errors: {
      type: Array
    },
    
    formGroupClass: {
      type: String,
      default: ""
    },
  },

  computed: {
    inputClass() {
      return {
        'is-invalid': this.errors,
        'text-right': true,
      };
    }
  },

  methods: {
    onInput(value) {
      this.$emit('input', Number(value));
      this.$emit('input-after');
    },
  }
}
</script>