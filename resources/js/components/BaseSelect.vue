<template>
  <div class="form-group" :class="formGroupClass">
    <label :for="id">{{ title }}</label>
    <select 
      class="form-control"
      :id="id"
      :value="value"
      :class="inputClass"
      @change="onChange($event.target.value)">
      <option
        v-if="hasEmptyItem"
        :value="emptyItem.value"
      >
        {{ emptyItem.caption }}
      </option>
      <option
        v-for="item in items"
        v-bind:key="item[itemValue]"
        v-bind:value="item[itemValue]"
      >
        {{ item[itemCaption] }}
      </option>
    </select>
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

    hasEmptyItem: {
      type: Boolean,
      default: true
    },

    formGroupClass: {
      type: String,
      default: ""
    },
  },

  data() {
    return {
      emptyItem: {
        value: null,
        caption: ""
      }
    }
  },

  computed: {
    inputClass() {
      return {
        'is-invalid': this.errors
      };
    }
  },

  methods: {
    onChange(value) {
      this.$emit('input', Number(value));
      this.$emit('change-after')
    }
  }
}
</script>