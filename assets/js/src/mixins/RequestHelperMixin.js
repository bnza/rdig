export const data = function () {
  return {
    isRequestPending: false
  }
}

export const methods = {
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
  }
}

export default {
  data: data,
  methods: methods
}
