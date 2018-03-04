import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('account', {
      $_AuthMx_isAuthenticated: 'isAuthenticated',
      authMxUsername: 'username'
    })
  }
}
