import { mapGetters } from 'vuex'

const readOnlyActions = ['read']
const privTables = ['site', 'area']

export default {
  computed: {
    ...mapGetters('account', {
      authMxIsAdmin: 'isAdmin',
      authMxIsAuthenticated: 'isAuthenticated',
      authMxUsername: 'username'
    })
  },
  methods: {
    authMxAuthorize (path) {
      const resolved = this.$router.resolve(path)
      const route = resolved.route

      if (route.matched.length > 0) {
        if (route.params.prefix === 'admin') {
          return this.authMxIsAdmin
        } else {
          if (route.params && route.params.hasOwnProperty('action')) {
            if (readOnlyActions.indexOf(route.params.action) > -1) {
              return true
            } else {
              if (this.authMxIsAuthenticated) {
                let table = route.params.childTable || route.params.table
                if (privTables.indexOf(table) > -1) {
                  return this.authMxIsAdmin
                } else {
                  return true
                }
              } else {
                return false
              }
            }
          }
        }
        console.warn(`${path} does not resolve any action params. Authorization skipped`)
      }
      console.warn(`${path} does not match any route. Authorization skipped`)
    }
  }
}
