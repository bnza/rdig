export default {
  data: function() {
    return {
      sortCriteria: {
        field: 'id',
        order: 'ASC'
      }
    }
  },
  components: {
/*    DataTable: () => import(
      /!* webpackChunkName: "DataTable" *!/
      '../components/DataTable'
      ),
    DataTableRowCellHead: () => import(
      /!* webpackChunkName: "DataTableRowCellHead" *!/
      '../components/DataTableRowCellHead'
      ),*/
  },
  methods: {
    sort: function (criteria) {
      this.sortCriteria = criteria
    }
  }
}