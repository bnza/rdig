<template>
    <table class="table is-striped is-hoverable">
        <thead>
        <slot name="header"></slot>
        </thead>
        <tbody>
        <template v-if="tableData">
            <tr v-for="row in tableData">
                <template v-for="(value, key) in row">
                    <th v-if="key === 'id'">
                        <router-link :to="{ name: 'data_element', params: { action: 'read', id: value }}" title="Show element">
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
  import DataTableMixin from '../mixins/DataTableMixin'

  export default {
    data: function() {
      return {
        tableData: null,
      }
    },
    props: [
      'tableName',
      'tableColumnsNum',
      'sortCriteria'
    ],
    mixins: [
      DataTableMixin
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