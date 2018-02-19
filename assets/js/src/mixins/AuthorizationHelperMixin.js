export default {
  methods: {
    authorize: function (path) {
      return true
      //return this.$store.getters['account/isAuthorized'](path, this.$router)
    }
  }
}
