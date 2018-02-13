<template>
    <table class="table is-striped is-hoverable is-fullwidth">
        <thead>
        <tr>
            <td v-bind:colspan="tableColumnsNum" style="border-bottom: 0">
                <router-link v-if="authorize(createPath)"
                             v-bind:to="createPath"
                             title="Create new item"
                >
                    <span class="icon has-text-success is-pulled-right">
                        <i class="fa fa-2x fa-plus-square"></i>
                    </span>
                </router-link>
                <span v-else class="icon has-text-grey-lighter is-pulled-right">
                        <i class="fa fa-2x fa-plus-square"></i>
                </span>
            </td>
        </tr>
        <slot name="header"></slot>
        </thead>
        <tbody>
        <template v-if="hasData">
            <tr v-for="row in tableData">
                <template v-for="(value, key) in row">
                    <component
                        v-if="key === 'id'"
                        v-bind:is="tableHeaderCellElementComponent"
                        v-bind:id="value"
                    />
                    <td v-else>
                        {{value}}
                    </td>
                </template>
            </tr>
        </template>
        <template v-else-if="isRequestPending">
            <tr class="has-text-centered">
                <td class="has-text-centered" v-bind:colspan="tableColumnsNum">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </td>
            <tr/>
        </template>
        <template v-else>
            <tr class="has-text-centered">
                <td class="has-text-centered" v-bind:colspan="tableColumnsNum">
                    <span class="has-text-grey">No items found</span>
                </td>
            <tr/>
        </template>
        </tbody>
    </table>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataTableMixin from '../mixins/DataTableMixin'
  import AuthorizationHelperMixin from '../mixins/AuthorizationHelperMixin'
  import TableHeaderCellElementIdShow from './TableHeaderCellElementIdShow'

  export default {
    data: function () {
      return {
        tableData: null,
      }
    },
    props: [
      'routePrefix',
      'tableName',
      'tableColumnsNum',
      'sortCriteria',
      'parent',
      'tableHeaderCellElementProp'
    ],
    computed: {
      tableHeaderCellElementComponent: function () {
        return this.tableHeaderCellElementProp || TableHeaderCellElementIdShow
      }
    },
    mixins: [
      PathHelperMixin,
      DataTableMixin,
      AuthorizationHelperMixin
    ],
    watch: {
      sortCriteria: function () {
        this.fetchData()
      }
    },
    name: "DataTable"
  }
</script>

<style scoped>

</style>