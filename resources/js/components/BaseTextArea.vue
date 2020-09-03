<template>
  <div class="form-group" :class="formGroupClass">
    <label :for="id">{{ title }}</label>
    <textarea
      class="form-control"
      type="text"
      rows="3"
      :id="id"
      :value="value"
      :class="inputClass"
      @input="$emit('input', $event.target.value)">
    </textarea>
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
      type: String    
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
        'is-invalid': this.errors
      };
    }
  },
}
</script>