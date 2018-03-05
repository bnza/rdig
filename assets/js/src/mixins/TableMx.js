/**
 *
 * Requires PathMx, UuidMx
 */

export const tableMxOpenModal = function (item, callerUuid, modalUuid) {
  callerUuid = callerUuid || this.uuid
  if (!callerUuid) {
    throw new Error(`The caller UUID must be provided when opening '${modalUuid}'`)
  }

}

export const tableMxOpenAddModal = function (item, callerUuid) {
  return this.tableMxOpenModal(item || {}, callerUuid, 'the-add-modal')
}

export const tableMxOpenDeleteModal = function (i, callerUuid) {
  let item = this.items[i]
  //this.tableMxOpenModal(this.items[i], callerUuid, )
  this.uuidMxSet('item', item, 'the-delete-modal')
  let path = this.routingMxGetDeletePath(item['id'])
  this.$router.push(path)
}

export const tableMxOpenEditModal = function (i, callerUuid) {
  let item = this.items && this.items[i] ? this.items[i] : {}
  this.tableMxOpenModal(item, callerUuid, 'the-edit-modal')
  let path = this.routingMxGetUpdatePath(item['id'])
  this.$router.push(path)
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
        url: this.routingMxListUrl
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
  }
}
