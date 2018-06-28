import { mapGetters } from 'vuex'

const readOnlyActions = ['read', 'search', 'download']
const privTables = ['site', 'area', 'campaign']

export const authMxAuthorize = (path, siteId, store, router) => {
  const authMxIsAdmin = store.getters['account/isAdmin']
  const authMxIsAuthenticated = store.getters['account/isAuthenticated']

  const resolved = typeof path === 'string'
    ? router.resolve(path)
    : false

  const route = resolved ? resolved.route : path

  if (route.matched.length > 0) {
    if (route.params.prefix === 'admin') {
      return authMxIsAdmin
    } else if (route.params.prefix === 'voc') {
      return authMxIsAuthenticated
    } else {
      if (route.params && route.params.hasOwnProperty('action')) {
        if (readOnlyActions.indexOf(route.params.action) > -1) {
          return true
        } else {
          if (authMxIsAuthenticated) {
            let table = route.params.childTable || route.params.table
            if (privTables.indexOf(table) > -1) {
              return authMxIsAdmin
            } else {
              if (siteId) {
                return authMxIsAdmin || store.getters['account/isSiteAllowed'](siteId)
              }
              return true
            }
          } else {
            return false
          }
        }
      } else if (route.hasOwnProperty('meta') && route.meta.hasOwnProperty('requiresRole')) {
        return authMxIsAdmin ||
          (
            authMxIsAuthenticated &&
            store.getters['account/roles'].indexOf(route.meta.requiresRole) > -1
          )
      }
    }
    console.warn(`${path} does not resolve any action params. Authorization skipped`)
  }
  console.warn(`${path} does not match any route. Authorization skipped`)
}

export default {
  computed: {
    ...mapGetters('account', {
      authMxIsAdmin: 'isAdmin',
      authMxIsAuthenticated: 'isAuthenticated',
      authMxUsername: 'username'
    })
  },
  methods: {
    authMxAuthorize (path, siteId) {
      return authMxAuthorize(path, siteId, this.$store, this.$router)
    }
  }
}
