import qs from 'qs'

export default {
  computed: {
    queryFromFullPath () {
      let query = this.$route.fullPath.match(/\?(.*)$/)
      if (query) {
        query = qs.parse(query[1])
      }
      return query
    },
    paginationFromFullPath () {
      const query = this.queryFromFullPath || {}
      const querySort = query.sort || {}
      const offset = query.offset || 0
      const rowsPerPage = query.limit || 25
      let sortBy = 'id'
      if (Object.keys(querySort).length > 0) {
        sortBy = Object.keys(querySort)[0]
      }
      return {
        rowsPerPage: rowsPerPage,
        page: Math.floor(offset / rowsPerPage) + 1,
        sortBy: sortBy,
        descending: querySort[sortBy] === 'DESC'
      }
    },
    searchCriteriaFromFullPath () {
      const query = this.queryFromFullPath || {}
      if (query.filter) {
        return query.filter
      }
    }
  }
}
