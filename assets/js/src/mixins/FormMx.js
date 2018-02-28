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
  computed: {
    $_FormMx_uuid () {
      return this.callerUuid || this.uuid
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
          if (error.response) {
            let text = 'ERROR: '
            if (error.response.data.error) {
              if (error.response.data.error.exception) {
                this.uuidMxSet('text', text + error.response.data.error.exception, 'the-snack-bar')
              }
            }
            this.uuidMxSet('color', 'error', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
          throw error
        }
      )
    },
    formMxCreate () {
      let config = {
        method: 'post',
        url: this.pathMxListUrl,
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
      let url = this.pathMxItemUrl
      if (url) {
        let config = {
          method: 'get',
          url: url
        }
        this.formMxCrud(config).then(
          (response) => {
            this.item = response.data
          }
        )
      }
    },
    formMxUpdate () {
      let url = this.pathMxItemUrl
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
      let url = this.pathMxItemUrl
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
    formMxValidate: debounce(function (key) {
      if (key) {
        this.$v[key].$touch()
      }
      this.uuidMxSet('isInvalid', this.$v.$invalid, this.$_FormMx_uuid)
    }, 250)
  }
}
