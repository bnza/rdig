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
/*    queryFromFullPath () {
      let query = this.$route.fullPath.match(/\?(.*)$/)
      if (query) {
        query = qs.parse(query[1])
      }
      return query
    },
    paginationFromFullPath () {
      const query = this.queryFromFullPath || {}
      const querySort = query.sort || {}
      const offset = query.offset || 0
      const rowsPerPage = query.limit || 25
      let sortBy = 'id'
      if (Object.keys(querySort).length > 0) {
        sortBy = Object.keys(querySort)[0]
      }
      return {
        rowsPerPage: rowsPerPage,
        page: Math.floor(offset / rowsPerPage) + 1,
        sortBy: sortBy,
        descending: querySort[sortBy] === 'DESC'
      }
    },
    searchCriteriaFromFullPath () {
      const query = this.queryFromFullPath || {}
      if (query.filter) {
        return query.filter
      }
    },
    tableMxFetchLimit () {
      return this.pagination.rowsPerPage || 25
    },
    tableMxFetchOffset () {
      return this.pagination.rowsPerPage * (this.pagination.page - 1)
    },
    tableMxFetchQuery () {
      let query = {
        limit: this.tableMxFetchLimit,
        offset: this.tableMxFetchOffset
      }
      if (this.pagination.sortBy) {
        query.sort = {
          [this.pagination.sortBy]: this.pagination.descending ? 'DESC' : 'ASC'
        }
      }
      if (this.searchCriteria) {
        query.filter = this.searchCriteria
      }
      return qs.stringify(query)
    },*/
    tableMxVisibleHeaders () {
      const vm = this
      const headers = this.rsTableMxHeaders.filter(function (item) {
        return vm.rsTableMxHeaderIsVisible(item.text)
      })
      return headers
    }
  },
  methods: {
/*    navigateToQuery () {
      let path = `${this.$route.path}?${this.tableMxFetchQuery}`
      this.$router.replace(path)
    },*/
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
