/**
 *
 * Requires PathMx
 */

export default {
  methods: {
    $_FormMx_fetch () {
      let url = this.$_PathMx_itemUrl
      if (url) {
        let config = {
          method: 'get',
          url: url
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.item = response.data
          }
        )
      }
    },
    $_FormMx_goToList () {
      this.$router.push({
        path: this.$_PathMx_listPath
      })
    }
  },
  created () {
    this.$_FormMx_fetch()
  }
}
