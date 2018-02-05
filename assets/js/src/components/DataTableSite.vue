<template>
    <DataTable tableName="site" v-bind:tableColumnsNum="3" v-bind:sortCriteria="sortCriteria">
        <tr slot="header">
            <DataTableRowCellHead
                label="id"
                field="id"
                v-on:sort="sort"
                v-bind:sortCriteria="sortCriteria"
            />
            <DataTableRowCellHead
                label="code"
                field="code"
                v-on:sort="sort"
                v-bind:sortCriteria="sortCriteria"
            />
            <DataTableRowCellHead
                label="name"
                field="name"
                v-on:sort="sort"
                v-bind:sortCriteria="sortCriteria"
            />
        </tr>
    </DataTable>
</template>

<script>
  export default {
    data: function() {
      return {
        sortCriteria: {
          field: 'id',
          order: 'ASC'
        }
      }
    },
    components: {
      DataTable: () => import(
        /* webpackChunkName: "DataTable" */
        './DataTable'
        ),
      DataTableRowCellHead: () => import(
        /* webpackChunkName: "DataTableRowCellHead" */
        './DataTableRowCellHead'
        ),
    },
    methods: {
      sort: function (criteria) {
        this.sortCriteria = criteria
      }
    },
    name: "DataTableSite"
  }
</script>

<style scoped>

</style>