export default {
  data: function () {
    return {
      isRequestPending: false,
      data: {},
      violations: {}
    }
  },
  computed: {
    method: function () {
      switch (this.$_route.action) {
        case 'update':
          return 'put'
        case 'delete':
          return 'delete'
        case 'create':
          return 'post'
        default:
          return 'get'
      }
    },
    submitUrl: function () {
      switch (this.method) {
        case 'post':
          return this.listUrl
        case 'put':
        case 'delete':
          return this.itemUrl
        default:
          throw new RangeError(`Unsupported method ${this.method}`)
      }
    },
    submitConfig: function () {
      return {
        method: this.method,
        url: this.submitUrl,
        data: this.data
      }
    }
  },
  methods: {
    handleRequestError: function (reason) {
      if (reason.response) {
        this.$store.dispatch('messages/handleResponseError', reason.response)
        if (reason.response.data && reason.response.data.error) {
          let error = reason.response.data.error
          if (error.hasOwnProperty('violations')) {
            let violations = {}
            for (let i = 0; i < error.violations.length; i++) {
              // TODO is array the right way?
              violations[error.violations[i].property] = error.violations[i].message
            }
            this.violations = violations
          }
        } else {
          console.warn('Unsupported error response format')
        }
      }
    },
    /**
     * Goes to next url: list for DELETE and item for PUT, POST (which have id)
     */
    next: function (id) {
      let path = id ? this.getItemPath(id) : this.listPath
      this.$router.push(path)
    },
    performRequest: function (config, successCb, errorCb) {
      this.isRequestPending = true
      return this.$store.dispatch('requests/perform', config)
        .then(
          (response) => {
            this.isRequestPending = false
            return response
          }
        )
        .catch(
          (reason) => {
            this.isRequestPending = false
            throw reason
          }
        )
    },
    /**
     * Perform the GET HTTP request for the single item
     */
    readData () {
      let url = this.itemUrl // from PathHelperMixin
      // no data fetch on create
      if (this.fetch && url) {
        let config = {
          method: 'get',
          url: url
        }
        this.isRequestPending = true
        this.$store.dispatch('requests/perform', config)
          .then(
            (response) => {
              this.isRequestPending = false
              this.data = response.data
            }
          )
          .catch(
            (reason) => {
              this.isRequestPending = false
              return reason
            }
          )
      }
    },
    submitRequest: function (config) {
      this.violations = {}
      config = config || this.submitConfig
      this.performRequest(config)
        .then(
          (response) => {
            let id = false
            if (response.data) {
              if (response.data.hasOwnProperty('id')) {
                id = response.data.id
              }
            }
            this.next(id)
          }
        )
        .catch(
          this.handleRequestError
        )
    }
  }
}
