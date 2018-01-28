<template>
    <DataTable tableName="site" v-bind:tableColumnsNum="3">
        <tr slot="header">
            <DataTableRowCellHead/>
            <DataTableRowCellHead label="code"/>
            <DataTableRowCellHead label="name"/>
        </tr>
    </DataTable>
</template>

<script>
  export default {
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
    name: "DataTableSite"
  }
</script>

<style scoped>

</style>