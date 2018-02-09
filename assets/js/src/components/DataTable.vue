<template>
    <table class="table is-striped is-hoverable">
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
        <template v-if="tableData">
            <tr v-for="row in tableData">
                <template v-for="(value, key) in row">
                    <th v-if="key === 'id'">
                        <router-link
                            v-bind:to="getItemPath(value)"
                            title="Show element"
                        >
                            <i class="fa fa-arrow-right"></i>
                        </router-link>
                    </th>
                    <td v-else>
                        {{value}}
                    </td>
                </template>
            </tr>
        </template>
        <template v-else>
            <tr class="has-text-centered">
                <td class="has-text-centered" v-bind:colspan="tableColumnsNum">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
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

  export default {
    data: function() {
      return {
        tableData: null,
      }
    },
    props: [
      'routePrefix',
      'tableName',
      'tableColumnsNum',
      'sortCriteria'
    ],
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