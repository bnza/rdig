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
    rsTableMxHeader (key) {
      return this.rsTableMxHeaders[key]
    },
    rsTableMxHeaderIsVisible (key) {
      const header = this.rsTableMxHeaders.find(function (item) {
        return item.text === key
      })
      if (!header) {
        return false
      }
      if (header.hasOwnProperty('public')) {
        if (!header.public) {
          return this.$store.getters['account/isAuthenticated']
        }
        return true
      } else {
        return true
      }
    }
  }
}
