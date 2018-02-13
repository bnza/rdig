import Vue from 'vue'
import {kebabize} from '../util'

export default {
  props: {
    route: {
      type: Object,
      default: function () {
        return {
          prefix: '',
          table: '',
          id: false,
          action: ''
        }
      }
    }
  },
  created: function () {
    if (this.id) {
      Vue.set(this.route, 'id', this.id)
    }
  },
  computed: {
    $_route: function () {
      return {
        prefix: this.route.prefix || this.$route.params.prefix,
        table: kebabize(this.route.table || this.$route.params.table),
        id: this.route.id || this.$route.params.id,
        action: this.route.action || this.$route.params.action
      }
    },
    basePath: function () {
      return `/${this.listUrl}`
    },
    baseItemPath: function () {
      return `/${this.itemUrl}`
    },
    listPath: function () {
      return `${this.basePath}/read`
    },
    itemPath: function () {
      return `/${this.itemUrl}/read`
    },
    createPath: function () {
      return `${this.basePath}/create`
    },
    deletePath: function () {
      return `${this.baseItemPath}/delete`
    },
    updatePath: function () {
      return `${this.baseItemPath}/update`
    },
    listUrl: function () {
      return `${this.$_route.prefix}/${this.$_route.table}`
    },
    itemUrl: function () {
      return `${this.$_route.prefix}/${this.$_route.table}/${this.$_route.id}`
    }
  },
  methods: {
    getDeletePath: function (id) {
      return `${this.basePath}/${id}/delete`
    },
    getItemPath: function (id) {
      return `${this.basePath}/${id}/read`
    },
    getUpdatePath: function (id) {
      return `${this.basePath}/${id}/update`
    }
  }
}
