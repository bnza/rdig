import Vue from 'vue'
import FormFieldHorizontal from '../components/FormFieldHorizontal'
import DataFormButtonGroup from '../components/DataFormButtonGroup'

export default {
  data: function () {
    return {
      isRequestPending: false,
      formData: null
    }
  },
  components: {
    FormFieldHorizontal,
    DataFormButtonGroup
  },
  computed: {
/*    listPath: function () {
      return `/${this.listUrl}/read`
    },
    itemPath: function () {
      return `/${this.itemUrl}/read`
    },
    listUrl: function () {
      return `${this.routePrefix}/${this.tableName}`
    },
    itemUrl: function () {
      return `${this.routePrefix}/${this.tableName}/${this.id}`
    },*/
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
        data: this.formData
      }
    }
  },
  methods: {
    /**
     * Returns to previous url: list for DELETE, POST and item for PUT
     */
    back: function () {
      let path = this.method === 'put' ? this.itemPath : this.listPath
      this.$router.replace(path)
    },
    /**
     * Goes to next url: list for DELETE and item for PUT, POST (which have id)
     */
    next: function (id) {
      let path = id ? `/${this.listUrl}/${id}/read` : this.listPath
      this.$router.push(path)
    },
    /**
     * Clears field validation error messages
     */
    clearErrors: function () {
      for (let prop in this.fieldMessages) {
        this.fieldMessages[prop] = {}
      }
    },
    /**
     * Handles error's array returned by the submit request
     * @param violations
     */
    handleValidationErrors: function (violations) {
      for (let i = 0; i < violations.length; i++) {
        let violation = violations[i]
        if (this.fieldMessages && this.fieldMessages.hasOwnProperty(violation.property)) {
          Vue.set(
            this.fieldMessages,
            violation.property,
            {
              className: 'is-danger',
              message: violation.message
            }
          )
        } else {
          console.warn(`Form field "${violation.property}" does not exist`)
        }
      }
    },
    /**
     * Hides the delete confirm modal
     */
    hideDeleteModal: function () {
      this.$emit('hideDeleteModal')
    },
    /**
     * Performs the HTTP request with the given config object. Fires the given callbacks on success or error
     * @param config
     * @param successCb
     * @param errorCb
     */
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
            this.isRequestPending = false
            if (reason.response) {
              if (reason.response.data && reason.response.data.error) {
                let error = reason.response.data.error
                if (error.hasOwnProperty('violations')) {
                  this.handleValidationErrors(error.violations)
                }
              }
            }
            if (errorCb) {
              errorCb(reason.response, this)
            }
          }
        )
    },
    /**
     * Perform the GET HTTP request for the single item
     */
    readData () {
      let config = {
        method: 'get',
        url: `${this.routePrefix}/${this.tableName}/${this.id}`
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
    /**
     * Shows the delete confirm modal
     */
    showDeleteModal: function () {
      this.$emit('showDeleteModal')
    },
    submitRequest: function () {
      let showSuccessMessage = function (vm, id) {
        let message = ''
        switch (vm.method) {
          case 'delete':
            message = 'Item successfully deleted'
            break
          case 'put':
            message = 'Item successfully updated'
            break
          case 'post':
            message = 'Item successfully created'
            break
        }
        vm.$store.dispatch({
          type: 'messages/addMessage',
          body: message,
          className: 'is-success'
        })
      }
      let successCb = function (response, vm) {
        let id = false
        if (response.data && response.data.id) {
          id = response.data.id
        }
        vm.next(id)
        showSuccessMessage(vm, id)
      }
      let errorCb = function (response, vm) {
        vm.$store.dispatch('messages/handleResponseError', response)
        if (vm.method === 'delete') {
          vm.hideDeleteModal()
        }
      }
      this.performRequest(this.submitConfig, successCb, errorCb)
    }
  }
}
