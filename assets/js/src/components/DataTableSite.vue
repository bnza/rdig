<template>
    <base-table
        v-bind:tableConfigObject="tableConfigObject"
        v-bind:route="{}"
        v-bind="$props"
    />
</template>

<script>
  import BaseTable from './BaseTable'
  export default {
    name: "data-table-site",
    components:{
      BaseTable
    },
    data: function () {
      return {
        tableConfigObject: {
          columns: {
            id: {},
            code: {},
            name: {}
          }
        }
      }
    }
  }
</script>