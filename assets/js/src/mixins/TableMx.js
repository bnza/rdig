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
    },
    $_TableMx_openDeleteModal (id) {
      this.$_UuidMx_set('item', this.items[id], 'the-delete-modal')
      this.$_UuidMx_set('isDialogOpen', true, 'the-delete-modal')
    },
    $_TableMx_openEditModal () {
      console.log('$_TableMx_openEditModal')
    },
    $_TableMx_goToItem (id) {
      this.$router.push({
        path: this.$_PathMx_getItemPath(id)
      })
    }
  },
  created () {
    this.$_TableMx_fetch()
  }
}
