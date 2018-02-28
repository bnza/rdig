/**
 *
 * Requires PathMx, UuidMx
 */

export const tableMxOpenModal = function (item, callerUuid, modalUuid) {
  callerUuid = callerUuid || this.uuid
  if (!callerUuid) {
    throw new Error(`The caller UUID must be provided when opening '${modalUuid}'`)
  }
  this.uuidMxSet('parent', this.parent, modalUuid)
  this.uuidMxSet('table', this.table, modalUuid)
  this.uuidMxSet('opener', callerUuid, modalUuid)
  this.uuidMxSet('item', item, modalUuid)
  this.uuidMxSet('isDialogOpen', true, modalUuid)
}

export const tableMxOpenAddModal = function (item, callerUuid) {
  return this.tableMxOpenModal(item || {}, callerUuid, 'the-add-modal')
}

export const tableMxOpenDeleteModal = function (i, callerUuid) {
  return this.tableMxOpenModal(this.items[i], callerUuid, 'the-delete-modal')
}

export const tableMxOpenEditModal = function (i, callerUuid) {
  let item = this.items && this.items[i] ? this.items[i] : {}
  return this.tableMxOpenModal(item, callerUuid, 'the-edit-modal')
}

export const tableMxModalOpeners = {
  tableMxOpenModal,
  tableMxOpenAddModal,
  tableMxOpenDeleteModal,
  tableMxOpenEditModal
}

export default {
  methods: {
    tableMxFetch () {
      let config = {
        method: 'get',
        url: this.pathMxListUrl
      }
      this.isRequestPending = true
      this.$store.dispatch('requests/perform', config).then(
        (response) => {
          this.isRequestPending = false
          this.items = response.data
        }
      ).catch(
        (error) => {
          console.error(error)
          this.isRequestPending = false
        }
      )
    },
    ...tableMxModalOpeners,
    tableMxGoToItem (id) {
      this.$router.push({
        path: this.pathMxGetItemPath(id)
      })
    }
  },
  created () {
    this.uuidMxSet('reload', true)
  }
}
