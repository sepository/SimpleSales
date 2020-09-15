<template>
  <div class="form-group" :class="formGroupClass">
    <div class="form-check" :class="formCheckClass">
      <input
        class="form-check-input"
        type="checkbox"
        :id="id"
        :checked="value"
        :class="inputClass"
        @change="$emit('input', $event.target.checked ? 1 : 0)">
      <label
        v-if="title"
        class="form-check-label" 
        :for="id"
      >
        {{ title }}
      </label>
    </div>
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
      type: Number    
    },

    errors: {
      type: Array
    },
    
    formGroupClass: {
      type: String,
      default: ""
    },

    formCheckClass: {
      type: String,
      default: ""
    },

    formCheckInputClass: {
      type: String,
      default: ""
    },
  },

  computed: {
    inputClass() {
      return [
        {
          'is-invalid': this.errors,
        },
        this.formCheckInputClass,
      ];
    }
  }
}
</script>