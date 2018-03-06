export default {
  computed: {
    pathMxBasePath: function () {
      return `/${this.pathMxListUrl}`
    },
    pathMxListPath: function () {
      return `${this.pathMxBasePath}/read`
    },
    pathMxItemPath: function () {
      return `/${this.pathMxItemUrl}/read`
    },
    pathMxListUrl: function () {
      let url = ''
      if (this.parent) {
        url = `${this.prefix}/${this.parent.table}/${this.parent.id}/${this.table}`
      } else {
        url = `${this.prefix}/${this.table}`
      }
      return url
    },
    pathMxItemUrl: function () {
      // if id is in the from 100,100 (join tables) extract the second value
      let id = /^\d+,(\d+)/.exec(this.id)
      id = Array.isArray(id) ? id[1] : this.id
      return this.id ? `${this.pathMxListUrl}/${id}` : false
    }
  },
  methods: {
    pathMxGetDeletePath: function (id) {
      return `${this.pathMxBasePath}/${id}/delete`
    },
    pathMxGetItemPath: function (id) {
      return `${this.pathMxBasePath}/${id}/read`
    },
    pathMxGetUpdatePath: function (id) {
      return `${this.pathMxBasePath}/${id}/update`
    },
    pathMxGetChildListPath: function (childTable) {
      return childTable
        ? `/${this.pathMxItemUrl}/${childTable}/read`
        : this.pathMxItemPath
    },
    pathMxGoToList () {
      this.$router.push({
        path: this.pathMxListPath
      })
    }
  }
}
