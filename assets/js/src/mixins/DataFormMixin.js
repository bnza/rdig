import Vue from 'vue'

export default {
  data: function() {
    return {
      isRequestPending: false
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
