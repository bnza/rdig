/**
 *
 * Requires PathMx
 */

export default {
  data () {
    return {
      $_TableMx_items: []
    }
  },
  computed: {
    $_TableMx_queryUrl () {
      return this.$_PathMx_listUrl
    }
  },
  methods: {
    $_TableMx_fetch () {
      let config = {
        method: 'get',
        url: this.$_TableMx_queryUrl
      }
      this.$store.dispatch('requests/perform', config).then(
        (response) => {
          this.items = response.data
        }
      )
    }
  },
  created () {
    this.$_TableMx_fetch()
  }
}
