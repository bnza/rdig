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
    },
    $_TableMx_reload () {
      return this.$_UuidMx_get('reload')
    }
  },
  watch: {
    $_TableMx_reload (reload) {
      if (reload) {
        this.$_TableMx_fetch()
        this.$_UuidMx_set('reload', false)
      }
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
    $_TableMx_openDeleteModal (i) {
      this.$_UuidMx_set('item', this.items[i], 'the-delete-modal')
      this.$_UuidMx_set('isDialogOpen', true, 'the-delete-modal')
    },
    $_TableMx_openEditModal (i) {
      let item = this.items && this.items[i] ? this.items[i] : {}
      this.$_UuidMx_set('opener', this.uuid, 'the-edit-modal').then(
        () => {
          this.$_UuidMx_set('item', item, 'the-edit-modal').then(
            () => {
              this.$_UuidMx_set('isDialogOpen', true, 'the-edit-modal')
            }
          )
        }
      )
    },
    $_TableMx_goToItem (id) {
      this.$router.push({
        path: this.$_PathMx_getItemPath(id)
      })
    }
  },
  created () {
    this.$_UuidMx_set('reload', true).then(
      () => {
        this.$_TableMx_fetch()
      }
    )
  }
}
