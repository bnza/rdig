import store from '../store'
import { mapGetters } from 'vuex'

export const authorize = function (route) {
  console.log(route)
  console.log(store.getters['account/username'])
}

export default {
  computed: {
    ...mapGetters('account', {
      authMxisAdmin: 'isAdmin',
      authMxIsAuthenticated: 'isAuthenticated',
      authMxUsername: 'username'
    }),
    authorize
  }
}
