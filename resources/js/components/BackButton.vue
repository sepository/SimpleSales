<template>
  <router-link :to="linkTo">
    <button class="btn btn-outline-primary">
      <i class="fas fa-angle-left"></i> {{ $t('common.back') }}
    </button>
  </router-link>
</template>

<script>
export default {
  props: {
    linkTo: {
      type: Object
    },
  }
}
</script>