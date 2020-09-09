<template>
  <div>
    <div class="d-flex">
      <h1 class="mx-auto">
        {{ title }}
      </h1>
    </div>

    <div class="d-flex my-2">
      <div>
        <form class="form-inline" @submit.prevent="onSubmit(keyword)">
          <label class="sr-only" for="keyword">Keyword</label>
          <div class="input-group">
            <div v-if="filterEnabled" class="input-group-prepend">
              <button 
                type="button"
                class="btn btn-outline-secondary dropdown-toggle"
                data-toggle="collapse"
                data-target="#collapseFilter"
                aria-expanded="false"
                aria-controls="collapseFilter"
              >
                {{ $t('common.filter') }}
              </button>
            </div>

            <div v-else class="input-group-prepend">
              <div class="input-group-text">
                {{ $t('common.search') }}
              </div>
            </div>

            <input
              id="keyword"
              v-model="keyword"
              type="text"
              class="form-control"
            >
          </div>
        </form>
      </div>

      <div class="ml-auto">
        <router-link v-if="linkToNew" :to="linkToNew">
          <button type="button" class="btn btn-primary">
            {{ $t('common.new') }}
          </button>
        </router-link>
      </div>
    </div>

    <div v-if="filterEnabled" id="collapseFilter" class="collapse">
      <div class="card card-body">
        <div class="row">
          <slot name="filters"></slot>
        </div>
        <div class="d-flex">
          <button
            type="button"
            class="btn btn-primary ml-auto"
            data-toggle="collapse"
            data-target="#collapseFilter"
            aria-expanded="false"
            aria-controls="collapseFilter"
            @click="onSubmit(keyword)"
          >
            {{ $t('common.search') }}
          </button>
        </div>
      </div>
    </div>

    <!-- 検索結果部分 -->
    <slot></slot>

    <div class="d-flex">
      <div class="ml-auto">
        <slot name="paginate"></slot>
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

    filterEnabled: {
      type: Boolean,
      default: false
    },

    linkToNew: {
      type: Object
    },

    onSubmit: {
      type: Function
    },
  },

  data() {
    return {
      keyword: ""
    }
  },

  methods: {
    submit() {
      this.onSubmit(this.keyword);
    },
  },
}
</script>