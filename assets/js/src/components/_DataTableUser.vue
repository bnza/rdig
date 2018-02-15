<template>
    <DataTable
        routePrefix="admin"
        tableName="user"
        v-bind:tableColumnsNum="4"
        v-bind:sortCriteria="sortCriteria"
    >
        <tr slot="header">
            <DataTableRowCellHead
                label="id"
                field="id"
                v-on:sort="sort"
                v-bind:sortCriteria="sortCriteria"
            />
            <DataTableRowCellHead
                label="username"
                field="username"
                v-on:sort="sort"
                v-bind:sortCriteria="sortCriteria"
            />
            <DataTableRowCellHead
                label="password"
                field="password"
                v-on:sort="sort"
                v-bind:sortCriteria="sortCriteria"
            />
            <DataTableRowCellHead
                label="roles"
                field="roles"
                v-on:sort="sort"
                v-bind:sortCriteria="sortCriteria"
            />
        </tr>
    </DataTable>
</template>

<script>
  import DataTableHeaderMixin from '../mixins/DataTableHeaderMixin'
  export default {
    mixins: [
      DataTableHeaderMixin
    ],
    name: "DataTableUser"
  }
</script>

<style scoped>

</style>