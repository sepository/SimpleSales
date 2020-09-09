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
      :language="language"
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
import {en, ja} from 'vuejs-datepicker/dist/locale'
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

    language() {
      let locale = this.$i18n.locale;
      let language = en;
      switch (locale) {
        case 'ja':
          language = ja;
          break;
      }
      return language;
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