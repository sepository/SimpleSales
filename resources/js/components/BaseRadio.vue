<template>
  <div class="form-group" :class="formGroupClass">
    <label class="w-100">{{ title }}</label>
    <div class="btn-group btn-group-toggle" :class="btnGroupClass">
      <label
        v-for="item in items"
        v-bind:key="item[itemValue]"
        class="btn btn-outline-secondary"
        :class="{'active': value == item[itemValue]}">
        <input
          type="radio"
          autocomplete="off"
          :name="id"
          :id="id + item[itemValue]"
          :value="item[itemValue]"
          :checked="value == item[itemValue]"
          @change="$emit('input', Number($event.target.value))">
        {{ item[itemCaption] }}
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

    items: {
      type: Array,
      default: []
    },

    itemValue: {
      type: String,
      default: "value"
    },

    itemCaption: {
      type: String,
      default: "caption"
    },

    formGroupClass: {
      type: String,
      default: ""
    },
  },

  computed: {
    btnGroupClass() {
      return {
        'is-invalid': this.errors
      };
    }
  },
}
</script>