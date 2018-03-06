<template>
    <tbody>
    <template v-if="tableData.length > 0">
       <base-table-row
            v-for="(rowData, index) in tableData"
            v-bind:key="'r-'+index"
            v-bind:rowData="rowData"
            v-bind:uuid="uuid"
            v-bind:index="index"
            v-on="$listeners"
        >
        </base-table-row>
    </template>
    <template v-else-if="$store.getters['components/tables/isRequestPending'](uuid)">
        <tr class="has-text-centered">
            <td class="has-text-centered" v-bind:colspan="$store.getters['components/tables/tableColumnsNum'](uuid)">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </td>
        <tr/>
    </template>
    <template v-else>
        <tr class="has-text-centered">
            <td class="has-text-centered" v-bind:colspan="$store.getters['components/tables/tableColumnsNum'](uuid)">
                <span class="has-text-grey">No items found</span>
            </td>
        <tr/>
    </template>
    </tbody>
</template>

<script>
  import BaseTableRow from './BaseTableRow'

  export default {
    name: 'base-table-body',
    props: {
      uuid: {
        type: Number,
        required: true
      },
      tableData: {
        type: Array,
        required: false,
        default: function () {
          return {}
        }
      },
      tableIsRequestPending: {
        type: Boolean,
        required: false,
        default: function () {
          return false
        }
      }
    },
    components: {
      BaseTableRow,
    },
    methods: {
    }
  }
</script>

<style scoped>

</style>