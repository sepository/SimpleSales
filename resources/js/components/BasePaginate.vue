<template>
  <Paginate
    :page-count="pageCount"
    :page-range="3"
    :margin-pages="1"
    :click-handler="clickPageNum"
    :prev-text="'<<'"
    :next-text="'>>'"
    :container-class="'pagination'"
    :page-class="'page-item'"
    :prev-class="'page-item'"
    :next-class="'page-item'"
    :page-link-class="'page-link'"
    :prev-link-class="'page-link'"
    :next-link-class="'page-link'">
  </Paginate>
</template>

<script>
export default {
  props: {
    pageCount: Number,
    currentPage: Number
  },

  methods: {
    clickPageNum(pageNum) {
      this.$emit('update:currentPage', pageNum);
    }
  }
}
</script>