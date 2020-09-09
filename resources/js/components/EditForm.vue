<template>
  <div class="container" :style="style">
    <div>
      <BackButton :link-to="linkToBack"/>
    </div>

    <div class="card my-2">
      <div class="card-header bg-secondary text-light text-center">
        {{ title }}
      </div>

      <div class="card-body">
        <form @submit.prevent="onSubmit">
          <slot></slot>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">
              {{ submitText }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String
    },

    linkToBack: {
      type: Object
    },

    onSubmit: {
      type: Function
    },

    submitText: {
      type: String
    },

    maxWidth: {
      type: String,
      default: "600px"
    },
  },

  computed: {
    style() {
      return {
        maxWidth: this.maxWidth
      };
    },
  },
}
</script>