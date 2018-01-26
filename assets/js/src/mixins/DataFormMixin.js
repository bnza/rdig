import Vue from 'vue'

export default {
  data: function () {
    return {
      isRequestPending: false,
      formData: null
    }
  },
  computed: {
    submitUrl: function () {
      switch (this.method) {
        case 'post':
          return `data/${this.tableName}`
        case 'put':
        case 'delete':
          return `data/${this.tableName}/${this.id}`
        default:
          throw new RangeError(`Unsupported method ${this.method}`)
      }
    },
    submitConfig: function () {
      return {
        method: this.method,
        url: this.submitUrl,
        data: this.formData
      }
    }
  },
  methods: {
    clearErrors: function () {
      for (let prop in this.fieldMessages) {
        this.fieldMessages[prop] = {}
      }
    },
    readData () {
      let config = {
        method: 'get',
        url: `data/${this.tableName}/${this.id}`
      }
      this.$store.dispatch('requests/perform', config)
        .then(
          (response) => {
            this.formData = response.data
          }
        )
        .catch(
          this.handleErrors
        )
    },
    handleErrors: function (reason) {
      this.isRequestPending = false
      if (reason.response) {
        if (reason.response.data && reason.response.data.error) {
          let error = reason.response.data.error
          if (error.violations) {
            for (let i = 0; i < error.violations.length; i++) {
              let violation = error.violations[i]
              if (this.fieldMessages && this.fieldMessages.hasOwnProperty(violation.property)) {
                Vue.set(this.fieldMessages[violation.property] = {
                  className: 'is-danger',
                  message: violation.message
                })
              } else {
                console.warn(`Form field "${violation.property}" does not exist`)
              }
            }
          }
        }
      }
    },
    submitRequest: function () {
      let successCb = function (response, vm) {
        let path = `/data/${vm.tableName}/${response.data.id}/read`
        vm.$router.replace(path)
      }
      this.performRequest(this.submitConfig, successCb)
    },
    performRequest: function (config, successCb) {
      this.clearErrors()
      this.isRequestPending = true
      this.$store.dispatch('requests/perform', config)
        .then(
          (response) => {
            this.isRequestPending = false
            successCb(response, this)
          }
        )
        .catch(
          this.handleErrors
        )
    }
  }
}
