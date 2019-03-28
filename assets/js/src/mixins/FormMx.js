/**
 *
 * Requires PathMx, UUidMx
 */
import {debounce} from '../util'

export default {
  props: {
    callerUuid: {
      type: String
    }
  },
  data () {
    return {
      violations: []
    }
  },
  computed: {
    $_FormMx_uuid () {
      return this.callerUuid || this.uuid
    },
    formMxIsInvalid () {
      return this.$v ? this.$v.$invalid : false
    }
  },
  methods: {
    formMxCrud (config) {
      this.isRequestPending = true
      return this.$store.dispatch('requests/perform', config).then(
        (response) => {
          this.isRequestPending = false
          return response
        }
      ).catch(
        (error) => {
          this.isRequestPending = false
          let text = 'ERROR: '
          if (error.response) {
            if (error.response.data.error) {
              if (error.response.data.error.exception) {
                this.uuidMxSet('text', text + error.response.data.error.exception, 'the-snack-bar')
              } else if (error.response.data.error.violations) {
                this.violations = error.response.data.error.violations;
                this.uuidMxSet('text', text + error.response.data.error.violations[0].message, 'the-snack-bar')
              }
            } else if (error.response.data) {
              this.uuidMxSet('text', text + error.response.data, 'the-snack-bar')
            }
          }
          this.uuidMxSet('color', 'error', 'the-snack-bar')
          this.uuidMxSet('active', true, 'the-snack-bar')
          throw error
        }
      )
    },
    formMxCreate () {
      let config = {
        method: 'post',
        url: this.routingMxListUrl,
        data: this.item
      }
      return this.formMxCrud(config).then(
        (response) => {
          this.item = response.data
          this.uuidMxSet('text', 'Successfully created item', 'the-snack-bar')
          this.uuidMxSet('color', 'success', 'the-snack-bar')
          this.uuidMxSet('active', true, 'the-snack-bar')
        }
      )
    },
    formMxRead () {
      let url = this.routingMxItemUrl
      if (url) {
        let config = {
          method: 'get',
          url: url
        }
        return this.formMxCrud(config).then(
          (response) => {
            this.item = response.data
          }
        ).catch(
          (error) => {
            if (error.response) {
              this.routingMxBack()
            }
          }
        )
      }
    },
    formMxUpdate () {
      let url = this.routingMxItemUrl
      if (url) {
        let config = {
          method: 'put',
          url: url,
          data: this.item
        }
        return this.formMxCrud(config).then(
          (response) => {
            this.item = response.data
            this.uuidMxSet('text', 'Successfully updated item', 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        )
      }
    },
    formMxDelete () {
      let url = this.routingMxItemUrl
      if (url) {
        let config = {
          method: 'delete',
          url: url
        }
        return this.formMxCrud(config).then(
          () => {
            this.uuidMxSet('text', 'Successfully deleted item', 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        )
      }
    },
    formMxGoToList () {
      this.$router.push({
        path: this.pathMxListPath
      })
    },
/*    formMxValidate (key) {
      if (key) {
        this.$v[key].$touch()
      }
      this.uuidMxSet('isInvalid', this.$v.$invalid, this.$_FormMx_uuid)
    },*/
    getViolationMessage (key) {
      const violation = this.violations.find((item) => {
        return item.property === key
      })
      if (violation) {
        return violation.message
      }
    }
  },
  watch: {
    formMxIsInvalid (flag) {
      this.uuidMxSet('isInvalid', flag, this.$_FormMx_uuid)
    }
  }
}

/*debounce(function (key) {
  if (key) {
    this.$v[key].$touch()
  }
  this.uuidMxSet('isInvalid', this.$v.$invalid, this.$_FormMx_uuid)
}, 250),*/
