<template>
  <div class="card p-0 my-2">
    <div class="table-responsive">
      <table class="table table-hover m-0">
        <thead>
          <tr class="table-secondary">
            <th
              v-for="column in columns"
              v-bind:key="column"
              scope="col"
              class="border-0"
            >
              {{ column }}
            </th>
          </tr>
        </thead>
        <tbody>
          <slot></slot>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    columns: {
      type: Array
    },
  },
}
</script>