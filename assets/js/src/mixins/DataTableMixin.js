import qs from 'qs'

export default {
  created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  methods: {
    getBaseUrl () {
      return `data/${this.tableName}`
    },
    getQueryUrl () {
      let url = this.getBaseUrl()
      let sortCriteria = {}
      sortCriteria[this.sortCriteria.field] = this.sortCriteria.order
      let orderQuery = qs.stringify({sort: sortCriteria}, { encode: false })
      if (orderQuery) {
        url += `?${orderQuery}`
      }
      return url
    },
    fetchData () {
      let config = {
        method: 'get',
        url: this.getQueryUrl()
      }
      this.$store.dispatch('requests/perform', config)
        .then(
          (response) => {
            this.tableData = response.data
          }
        )
        .catch(
          this.handleErrors
        )
    }
  }
}
