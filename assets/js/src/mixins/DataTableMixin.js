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
    fetchData () {
      let config = {
        method: 'get',
        url: this.getBaseUrl()
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