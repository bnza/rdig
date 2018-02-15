<script>
  import BaseTable from './BaseTable'

  export default {
    name: "data-table-user",
    extends: BaseTable,
    data: function () {
      return {
        tableConfigObject: {
          columns: {
            id: {},
            username: {},
            password: {},
            roles: {}
          }
        }
      }
    }
  }
</script>

<style scoped>

</style>