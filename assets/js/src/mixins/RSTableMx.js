/**
 * Retrieves table data options from store optionally using route data
 *
 */

export default {
  props: {
    tableName: {
      type: String,
      default: ''
    }
  },
  computed: {
    $_RSTableMx_tableName () {
      return this.tableName || this.$route.params.table
    },
    $_RSTableMx_tables () {
      return this.$store.state.tables
    },
    $_RSTableMx_table () {
      return this.$store.state.tables[this.$_RSTableMx_tableName]
    },
    $_RSTableMx_headers () {
      return this.$_RSTableMx_table.headers
    },
    $_RSTableMx_maxWidth () {
      return this.$_RSTableMx_table.maxWidth
    }
  },
  methods: {
    $_RSTableMx_header (key) {
      return this.$_RSTableMx_headers[key]
    }
  }
}
