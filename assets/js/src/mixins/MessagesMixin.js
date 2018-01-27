export default {
  computed: {
    appMessage: function () {
      return this.$store.state.message.body
    },
    appMessageClass: function () {
      return this.$store.state.message.className
    }
  }
}
