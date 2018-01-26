export default {
  computed: {
    appMessage: function () {
      return this.$store.message.body
    },
    appMessageClass: function () {
      return this.$store.message.className
    }
  }
}