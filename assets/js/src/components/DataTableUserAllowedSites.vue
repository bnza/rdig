<template>
    <DataTable
        routePrefix="admin"
        v-bind:parent="parent"
        v-bind:route="route"
        v-bind:tableColumnsNum="3"
        v-bind:sortCriteria="sortCriteria"
        v-bind:tableHeaderCellElementProp="tableHeaderCellElementProp"
        v-on:showDeleteModal="showDeleteModal"
    >
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
  import DataTableHeaderMixin from '../mixins/DataTableHeaderMixin'
  import TableHeaderCellElementIdDelete from './TableHeaderCellElementIdDelete'

  export default {
    props: ['parent', 'route'],
    mixins: [
      DataTableHeaderMixin
    ],
    computed: {
      tableHeaderCellElementProp: function () {
        return TableHeaderCellElementIdDelete
      }
    },
    name: "DataTableUsersAllowedSites"
  }
</script>

<style scoped>

</style>