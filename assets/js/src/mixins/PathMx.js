export default {
  computed: {
    $_PathMx_listUrl: function () {
      let url = ''
      let params = this.$route.params
      if (this.parent) {
        url = `${params.prefix}/${params.table}/${params.id}/${params.table}`
      } else {
        url = `${params.prefix}/${params.table}`
      }
      return url
    }
  }
}
