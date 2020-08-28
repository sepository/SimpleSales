<template>
  <router-link :to="{name: route}">
    <button class="btn btn-outline-primary">
      <i class="fas fa-angle-left"></i> 戻る
    </button>
  </router-link>
</template>

<script>
export default {
  props: {
    route: String
  }
}
</script>