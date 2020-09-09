<template>
  <button 
    class="btn btn-danger mx-1"
    :type="buttonType"
    :class="buttonClass"
    @click="$emit('click')"
  >
    {{ $t('common.delete') }}
  </button>
</template>

<script>
export default {
  props: {
    buttonType: {
      type: String,
      default: "button"
    },

    buttonClass: {
      type: String,
      default: ""
    },
  },
}
</script>