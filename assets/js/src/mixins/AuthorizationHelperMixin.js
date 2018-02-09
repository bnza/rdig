export default {
  methods: {
    userHasModifyRights (action, tableName) {
      if (this.$store.getters['account/isAuthenticated']) {
        if (this.$store.getters['account/isAdmin']) {
          return true
        }
        if (!this.isAdminTable(tableName)) {
          return true
        }
      }
      return false
    },
    isAdminTable: function (tableName) {
      return ['site', 'user'].indexOf(tableName) > -1
    },
    isUnprotectedReadTable: function (tableName) {
      return ['site', 'pottery', 'object'].indexOf(tableName) > -1
    },
    isReadOnlyAction: function (action) {
      return ['read', 'list'].indexOf(action) > -1
    },
    isPermittedToUnauthenticatedUser: function (action, tableName) {
      if (this.isReadOnlyAction(action)) {
        if (tableName) {
          return this.isUnprotectedReadTable(tableName)
        }
      }
      return false
    },
    authorize: function (path) {
      let {tableName, action} = this.$router.resolve(path).location.params
      if (!action || !tableName) {
        return false
      }
      if (this.isPermittedToUnauthenticatedUser(action, tableName)) {
        return true
      }
      if (this.userHasModifyRights(action, tableName)) {
        return true
      }
      return false
    }
  }
}
