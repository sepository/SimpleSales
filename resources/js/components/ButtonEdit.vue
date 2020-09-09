<template>
  <router-link
    :to="linkTo"
  >
    <button
      class="btn btn-primary mx-1"
      :type="buttonType"
      :class="buttonClass"
    >
      {{ $t('common.edit') }}
    </button>
  </router-link>
</template>

<script>
export default {
  props: {
    linkTo: {
      type: Object
    },

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