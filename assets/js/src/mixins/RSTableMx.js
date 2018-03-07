/**
 * Retrieves table data options from store optionally using route data
 *
 */

export default {
  computed: {
    rsTableMxTableName () {
      return this.table__ || this.$route.params.table
    },
    rsTableMxTables () {
      return this.$store.state.tables
    },
    rsTableMxTable () {
      return this.$store.state.tables[this.rsTableMxTableName]
    },
    rsTableMxHeaders () {
      return this.rsTableMxTable.headers
    },
    $_RSTableMx_maxWidth () {
      return this.rsTableMxTable.maxWidth
    }
  },
  methods: {
    $_RSTableMx_header (key) {
      return this.rsTableMxHeaders[key]
    }
  }
}
