<template>
  <div class="form-group" :class="formGroupClass">
    <label :for="id">{{ title }}</label>
    <input 
      class="form-control" 
      type="password" 
      :id="id" 
      :value="value" 
      :class="inputClass"
      @input="$emit('input', $event.target.value)">
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