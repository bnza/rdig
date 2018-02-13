import qs from 'qs'

export default {
  data: function () {
    return {
      isRequestPending: false
    }
  },
  created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  computed: {
    hasData: function () {
      return this.tableData && this.tableData.length > 0
    }
  },
  methods: {
    getBaseUrl () {
      let baseUrl = `${this.routePrefix}`
      if (this.parent) {
        baseUrl += `/${this.parent.table}/${this.$_route.id}/${this.$_route.table}`
      } else {
        baseUrl += `/${this.$_route.table}`
      }
      return baseUrl
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
      this.isRequestPending = true
      this.$store.dispatch('requests/perform', config)
        .then(
          (response) => {
            this.isRequestPending = false
            this.tableData = response.data
          }
        )
        .catch(
          (reason) => {
            if (reason.response) {
              this.isRequestPending = false
              this.$store.dispatch('messages/handleResponseError', reason.response)
            }
          }
        )
    }
  }
}
