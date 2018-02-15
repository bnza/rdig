<template>
    <th>
        <router-link
            v-bind:to="getItemPath(value)"
            title="Show item"
        >
            <i class="fa fa-arrow-right"></i>
        </router-link>
    </th>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import BaseTableDataCell from './BaseTableDataCell'
  export default {
    name: "show-table-data-cell",
    extends: BaseTableDataCell,
    mixins: [
      PathHelperMixin,
    ]
  }
</script>

<style scoped>

</style>