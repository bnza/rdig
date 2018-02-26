export default {
  computed: {
    $_PathMx_id () {
      return this.id || this.$route.params.id
    },
    $_PathMx_basePath: function () {
      return `/${this.$_PathMx_listUrl}`
    },
    $_PathMx_listPath: function () {
      return `${this.$_PathMx_basePath}/read`
    },
    $_PathMx_itemPath: function () {
      return `/${this.$_PathMx_itemUrl}/read`
    },
    $_PathMx_listUrl: function () {
      let url = ''
      let params = this.$route.params
      if (this.parent) {
        url = `${params.prefix}/${params.table}/${params.id}/${params.table}`
      } else {
        url = `${params.prefix}/${params.table}`
      }
      return url
    },
    $_PathMx_itemUrl: function () {
      return this.$_PathMx_id ? `${this.$_PathMx_listUrl}/${this.$_PathMx_id}` : false
    }
  },
  methods: {
    $_PathMx_getDeletePath: function (id) {
      return `${this.$_PathMx_basePath}/${id}/delete`
    },
    $_PathMx_getItemPath: function (id) {
      return `${this.$_PathMx_basePath}/${id}/read`
    },
    $_PathMx_getUpdatePath: function (id) {
      return `${this.$_PathMx_basePath}/${id}/update`
    }
  }
}
