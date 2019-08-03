export default {
  isAuthenticated: state => {
    return state.user && state.user.hasOwnProperty('username')
  },
  errorMessage: state => {
    return state.authError ? state.authError.data : ''
  },
  hasError: state => {
    return !!state.authError
  },
  username: (state, getters) => {
    return getters.isAuthenticated ? state.user.username : ''
  },
  roles: (state, getters) => {
    return getters.isAuthenticated ? state.user.roles : []
  },
  isSuperAdmin: (state, getters) => {
    return getters.roles.indexOf('ROLE_SUPER_ADMIN') > -1
  },
  isAdmin: (state, getters) => {
    return getters.roles.indexOf('ROLE_ADMIN') > -1 || getters.roles.indexOf('ROLE_SUPER_ADMIN') > -1
  },
  isSuperUser: (state, getters) => {
    return getters.roles.indexOf('ROLE_SUPER_USER') > -1 ||
      getters.roles.indexOf('ROLE_ADMIN') > -1 ||
      getters.roles.indexOf('ROLE_SUPER_ADMIN') > -1
  },
  isSiteAllowed: (state, getters) => (siteId) => {
    return getters.isAuthenticated && state.user.allowedSites.indexOf(siteId) > -1
  },
  isAuthorized: (state, getters) => (path, router) => {
    if (typeof path === 'string' || path instanceof String) {
      path = router.resolve(path).route
    }
    let {table, action} = path.params
    if (!action || !table) {
      return false
    }
    if (getters.isActionPermittedToUnauthenticatedUser(action, table)) {
      return true
    }
    if (getters.hasModifyRights(action, table)) {
      return true
    }
    return false
  },
  isReadOnlyAction: (state) => (action) => {
    return ['read', 'list'].indexOf(action) > -1
  },
  isUnprotectedReadTable: (state) => (table) => {
    return ['site', 'pottery', 'object'].indexOf(table) > -1
  },
  isAdminTable: (state) => (table) => {
    return ['site', 'user'].indexOf(table) > -1
  },
  isActionPermittedToUnauthenticatedUser: (state, getters) => (action, table) => {
    if (getters.isReadOnlyAction(action)) {
      if (table) {
        return getters.isUnprotectedReadTable(table)
      }
    }
    return false
  },
  hasModifyRights: (state, getters) => (action, table) => {
    if (getters.isAuthenticated) {
      if (getters.isAdmin) {
        return true
      }
      if (!getters.isAdminTable(table)) {
        return true
      }
    }
    return false
  },
  roleColor: (state, getters) => {
    // let color = 'black'
    // if (getters.roles.indexOf('ROLE_SUPER_ADMIN') > -1) {
    //   color = 'red darken-2'
    // } else if (getters.roles.indexOf('ROLE_ADMIN') > -1) {
    //   color = 'orange darken-2'
    // } else if (getters.roles.indexOf('ROLE_SUPER_USER') > -1) {
    //   color = 'yellow darken-2'
    // } else if (getters.roles.indexOf('ROLE_USER') > -1) {
    //   color = 'teal'
    // }
    // return color
    return getters.getRoleColor(getters.roles)
  },
  getRoleColor: () => (roles) => {
    let color = 'black'
    if (roles.indexOf('ROLE_SUPER_ADMIN') > -1) {
      color = 'red darken-2'
    } else if (roles.indexOf('ROLE_ADMIN') > -1) {
      color = 'orange darken-2'
    } else if (roles.indexOf('ROLE_SUPER_USER') > -1) {
      color = 'yellow darken-2'
    } else if (roles.indexOf('ROLE_USER') > -1) {
      color = 'teal'
    }
    return color
}
}
