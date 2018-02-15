<script>
  import BaseTable from './BaseTable'
  export default {
    name: "data-table-site",
    extends: BaseTable,
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

<style scoped>

</style>