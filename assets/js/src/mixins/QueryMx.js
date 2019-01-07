import qs from 'qs'

export default {

  data () {
    return {
      pagination: {
        page: 1,
        rowsPerPage: 25,
        sortBy: 'id',
        descending: false
      },
      dirty: false
    }
  },
  computed: {
    searchCriteria: {
      get () {
        return this.uuidMxGet('searchCriteria')
      },
      set (value) {
        this.uuidMxSet('searchCriteria', value)
      }
    },
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
      const rowsPerPage = query.limit || 10
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
    searchCriteriaFromFullPath() {
      const query = this.queryFromFullPath || {}
      if (query.filter) {
        return query.filter
      }
    },
    fetchQuery () {
      let query = {
        limit: this.fetchLimit,
        offset: this.fetchOffset
      }
      if (this.pagination.sortBy) {
        query.sort = {
          [this.pagination.sortBy]: this.pagination.descending ? 'DESC' : 'ASC'
        }
      }
      if (this.searchCriteria) {
        query.filter = this.searchCriteria
      }
      return qs.stringify(query)
    },
    fetchLimit () {
      return this.pagination.rowsPerPage || 25
    },
    fetchOffset () {
      return this.pagination.rowsPerPage * (this.pagination.page - 1)
    },
  },
  methods: {
    navigateToQuery () {
      let path = `${this.$route.path}?${this.fetchQuery}`
      this.$router.replace(path)
    }
  },
  watch: {
    pagination: {
      handler (value, oldValue) {
        if (!this.dirty) {
          this.navigateToQuery()
          this.fetch()
        }
      },
      deep: true
    },
    searchCriteria: {
      handler (value, oldValue) {
        if (!this.dirty) {
          this.navigateToQuery()
          this.fetch()
        }
      },
      deep: true
    }
  },
  created () {
    const pagination = this.paginationFromFullPath
    const searchCriteria = this.searchCriteriaFromFullPath
    if (pagination && searchCriteria) {
      this.dirty = true
      this.pagination = pagination
      this.dirty = false
      this.searchCriteria = searchCriteria
    } else if (searchCriteria) {
      this.searchCriteria = searchCriteria
    } else if (pagination) {
      this.pagination = pagination
    }
  }
}
