/**
 *
 * Requires PathMx, UuidMx
 */

import qs from 'qs'

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
  computed: {
    tableMxFetchLimit () {
      return this.pagination.rowsPerPage || 25
    },
    tableMxFetchOffset () {
      return this.pagination.rowsPerPage * (this.pagination.page - 1)
    },
    tableMxFetchQuery () {
      let query = {
        limit: this.tableMxFetchLimit,
        offset: this.tableMxFetchOffset,
      }
      if (this.pagination.sortBy) {
        query.sort = {
          [this.pagination.sortBy]: this.pagination.descending ? 'DESC' : 'ASC'
        }
      }
      return qs.stringify(query)
    }
  },
  methods: {
    tableMxFetch () {
      let url = `${this.routingMxListUrl}?${this.tableMxFetchQuery}`
      let config = {
        method: 'get',
        url: url
      }
      this.isRequestPending = true
      this.$store.dispatch('requests/perform', config).then(
        (response) => {
          this.isRequestPending = false
          this.totalItems = parseInt(response.data.totalItems)
          this.items = response.data.items
        }
      ).catch(
        (error) => {
          this.isRequestPending = false
          let text = 'ERROR: '
          if (error.response) {
            if (error.response) {
              this.uuidMxSet('text', text + error.response.data, 'the-snack-bar')
              this.uuidMxSet('color', 'error', 'the-snack-bar')
              this.uuidMxSet('active', true, 'the-snack-bar')
              if (error.response.status === 403) {
                this.routingMxBack()
              }
            }
          }
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
