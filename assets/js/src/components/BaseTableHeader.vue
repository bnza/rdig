<template>
    <thead>
        <base-table-header-row
            v-bind="$props"
        >
        </base-table-header-row>
    </thead>
</template>

<script>
  import BaseTableRow from './BaseTableRow'
  import BaseTableHeaderRow from "./BaseTableHeaderRow";
  export default {
    name: "base-table-header",
    components: {
      BaseTableHeaderRow,
      BaseTableRow
    },
    props: {
      uuid: {
        type: Number,
        required: true
      }
    },
  }
</script>

<style scoped>

</style>