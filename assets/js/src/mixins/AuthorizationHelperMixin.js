export default {
  methods: {
    authorize: function (path) {
      return this.$store.getters['account/isAuthorized'](path, this.$router)
    }
  }
}
