import qs from 'qs'

export const props = {
  parent: {
    type: Object,
    validator: function (value) {
      return value.hasOwnProperty('table') && value.hasOwnProperty('id')
    }
  },
  route: {
    type: Object
  }
}

export default {
  data: function () {
    return {
      // isRequestPending: false,
      tableData: [],
/*      sortCriteria: {
        id: 'ASC'
      }*/
    }
  },
  props: props,
  methods: {
    $_DataTableMixin_getBaseUrl () {
      let baseUrl = `${this.$_route.prefix}`
      if (this.parent) {
        baseUrl += `/${this.parent.table}/${this.$_route.id}/${this.$_route.table}`
      } else {
        baseUrl += `/${this.$_route.table}`
      }
      return baseUrl
    },
    $_DataTableMixin_getQueryUrl () {
      let url = this.$_DataTableMixin_getBaseUrl()
      let sortCriteria = this.$store.getters['components/tables/sortCriteria'](this.uuid)
      let orderQuery = qs.stringify({sort: sortCriteria}, { encode: false })
      if (orderQuery) {
        url += `?${orderQuery}`
      }
      return url
    },
    $_DataTableMixin_fetchData () {
      let config = {
        method: 'get',
        url: this.$_DataTableMixin_getQueryUrl()
      }
      this.$store.dispatch('components/tables/requestStarted', this.uuid)
      this.$store.dispatch('requests/perform', config)
        .then(
          (response) => {
            this.$store.dispatch('components/tables/requestCompleted', this.uuid)
            this.tableData = response.data
          }
        )
        .catch(
          (reason) => {
            if (reason.response) {
              this.$store.dispatch('components/tables/requestCompleted', this.uuid)
              this.$store.dispatch('messages/handleResponseError', reason.response)
            }
          }
        )
    }
  }
}
