/**
 *
 * Requires PathMx, UUidMx
 */

export default {
  props: {
    $_FormMx_uuidRef: {
      type: String
    }
  },
  computed: {
    $_FormMx_uuid () {
      return this.$_FormMx_uuidRef || this.uuid
    },
    $_FormMx_isRequestPending: {
      get () {
        return this.$_FormMx_uuid ? this.$_UuidMx_get('isRequestPending', this.$_FormMx_uuid) : false
      },
      set (value) {
        if (this.$_FormMx_uuid) {
          this.$_UuidMx_set('isRequestPending', value, this.$_FormMx_uuid)
        }
      }
    }
  },
  methods: {
    $_FormMx_crud (config) {
      this.$_FormMx_isRequestPending = true
      return this.$store.dispatch('requests/perform', config).then(
        (response) => {
          this.$_FormMx_isRequestPending = false
          return response
        }
      ).catch(
        (error) => {
          this.$_FormMx_isRequestPending = false
          throw error
        }
      )
    },
    $_FormMx_read () {
      let url = this.$_PathMx_itemUrl
      if (url) {
        let config = {
          method: 'get',
          url: url
        }
        this.$_FormMx_crud(config).then(
          (response) => {
            this.item = response.data
          }
        )
      }
    },
    $_FormMx_update () {
      let url = this.$_PathMx_itemUrl
      if (url) {
        let config = {
          method: 'put',
          url: url,
          data: this.item
        }
        return this.$_FormMx_crud(config).then(
          (response) => {
            this.item = response.data
          }
        )
      }
    },
    $_FormMx_delete () {
      let url = this.$_PathMx_itemUrl
      if (url) {
        let config = {
          method: 'delete',
          url: url
        }
        return this.$_FormMx_crud(config)
      }
    },
    $_FormMx_goToList () {
      this.$router.push({
        path: this.$_PathMx_listPath
      })
    },
    $_FormMx_validate (key) {
      if (this.$v) {
        this.$v[key].$touch()
        //this.$emit('validate', this.$v.$invalid)
        //this.$_UuidMx_set('isInvalid', this.$v.$invalid, this.uuid || this.$_UuidMx_uuid)
      }
    }
  },
  created () {
    this.$_FormMx_read()
  }
}
