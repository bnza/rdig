export default {
  computed: {
    basePath: function () {
      return `/${this.listUrl}`
    },
    baseItemPath: function () {
      return `/${this.itemUrl}`
    },
    listPath: function () {
      return `${this.basePath}/read`
    },
    itemPath: function () {
      return `/${this.itemUrl}/read`
    },
    createPath: function () {
      return `${this.basePath}/create`
    },
    deletePath: function () {
      return `${this.baseItemPath}/delete`
    },
    updatePath: function () {
      return `${this.baseItemPath}/update`
    },
    listUrl: function () {
      return `${this.routePrefix}/${this.tableName}`
    },
    itemUrl: function () {
      return `${this.routePrefix}/${this.tableName}/${this.id}`
    }
  },
  methods: {
    getDeletePath: function (id) {
      return `${this.basePath}/${id}/delete`
    },
    getItemPath: function (id) {
      return `${this.basePath}/${id}/read`
    },
    getUpdatePath: function (id) {
      return `${this.basePath}/${id}/update`
    }
  }
}
