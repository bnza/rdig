/**
 *
 * Requires PathMx, UuidMx
 */

import qs from 'qs'
import RSTableMx from './RSTableMx'
import QueryMx from './QueryMx'

export const tableMxOpenModal = function (item, callerUuid, modalUuid) {
  callerUuid = callerUuid || this.uuid
  if (!callerUuid) {
    throw new Error(`The caller UUID must be provided when opening '${modalUuid}'`)
  }
}

export const tableMxOpenAddModal = function (item, callerUuid) {
  return this.tableMxOpenModal(item || {}, callerUuid, 'the-add-modal')
}

/**
 * Replace path table with the given one
 * @param i
 * @param callerUuid
 * @param replace Object eg {finding: 'sample'}
 */
export const tableMxOpenDeleteModal = function (i, callerUuid, replace) {
  let item = this.items[i]
  this.uuidMxSet('item', item, 'the-delete-modal')
  let path = this.routingMxGetDeletePath(item['id'])
  if (replace) {
    const replaced = Object.keys(replace)[0]
    path = path.replace(replaced, replace[replaced])
  }
  this.$router.push(path)
}

export const tableMxOpenEditModal = function (i, callerUuid, replace) {
  let item = this.items && this.items[i] ? this.items[i] : {}
  this.tableMxOpenModal(item, callerUuid, 'the-edit-modal')
  let path = this.routingMxGetUpdatePath(item['id'])
  if (replace) {
    const replaced = Object.keys(replace)[0]
    path = path.replace(replaced, replace[replaced])
  }
  this.$router.push(path)
}

export const tableMxOpenSearchModal = function (callerUuid) {
  callerUuid = callerUuid || this.uuid
  // this.uuidMxSet('criteria', criteria, 'the-search-modal')
  this.uuidMxSet('callerUuid', callerUuid, 'the-search-modal')
  this.$router.push(this.routingMxSearchPath)
}

export const tableMxModalOpeners = {
  tableMxOpenModal,
  tableMxOpenAddModal,
  tableMxOpenDeleteModal,
  tableMxOpenEditModal
}

export default {
  mixins: [
    RSTableMx,
    QueryMx
  ],
  computed: {
    tableMxVisibleHeaders () {
      const vm = this
      const headers = this.rsTableMxHeaders.filter(function (item) {
        return vm.rsTableMxHeaderIsVisible(item.text)
      })
      return headers
    }
  },
  methods: {
    tableMxFetch () {
      let url = `${this.routingMxListUrl}?${this.fetchQuery}`
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
              if (error.response.data.error && error.response.data.error.exception) {
                text += error.response.data.error.exception
              } else {
                text += error.response.data
              }
              this.uuidMxSet('text', text, 'the-snack-bar')
              this.uuidMxSet('color', 'error', 'the-snack-bar')
              this.uuidMxSet('active', true, 'the-snack-bar')
              this.routingMxBack()
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
