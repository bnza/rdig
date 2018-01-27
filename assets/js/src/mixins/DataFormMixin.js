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
    hideDeleteModal: function () {
      this.$emit('hideDeleteModal')
    },
    performRequest: function (config, successCb, errorCb) {
      this.clearErrors()
      this.isRequestPending = true
      this.$store.dispatch('requests/perform', config)
        .then(
          (response) => {
            this.isRequestPending = false
            if (successCb) {
              successCb(response, this)
            }
          }
        )
        .catch(
          (reason) => {
            this.handleErrors(reason)
            if (errorCb) {
              errorCb(reason.response, this)
            }
          }
        )
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
    showDeleteModal: function () {
      this.$emit('showDeleteModal')
    },
    submitRequest: function () {
      let successCb = function (response, vm) {
        let path = ''
        if (response.data && response.data.id) {
          path = `/data/${vm.tableName}/${response.data.id}/read`
        } else {
          path = `/data/${vm.tableName}/read`
        }
        vm.$router.replace(path)
      }
      let errorCb = function (response, vm) {
        vm.$store.state.message.body = response.data.error
        vm.$store.state.message.className = 'is-danger'
        if (vm.method === 'delete') {
          vm.hideDeleteModal()
        }
      }
      this.performRequest(this.submitConfig, successCb, errorCb)
    }
  }
}
