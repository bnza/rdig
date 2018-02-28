export default {
  data () {
    return {
      pathMxItemIdD: 0,
      pathMxTableParentD: null,
      pathMxTableNameD: ''
    }
  },
  props: {
    pathMxTableParentP: {
      type: Object,
      validator (value) {
        return typeof value === 'undefined' || (value.hasOwnProperty('id') && value.hasOwnProperty('table'))
      }
    },
    pathMxItemIdP: {
      type: Number || String,
      validator (value) {
        return typeof value === 'number' || (value.split(',').length === 2)
      }
    },
    pathMxTableNameP: {
      type: Number || String,
      validator (value) {
        return typeof value === 'number' || (value.split(',').length === 2)
      }
    }
  },
  computed: {
    pathMxItemIdC () {
      return this.pathMxItemIdD || this.$route.params.id
    },
    pathMxBasePath: function () {
      return `/${this.pathMxListUrl}`
    },
    pathMxListPath: function () {
      return `${this.pathMxBasePath}/read`
    },
    pathMxItemPath: function () {
      return `/${this.pathMxItemUrl}/read`
    },
    pathMxListUrl: function () {
      let url = ''
      let params = this.$route.params
      if (this.pathMxTableParentD) {
        url = `${params.prefix}/${this.pathMxTableParentD.table}/${this.pathMxTableParentD.id}/${this.pathMxTableNameD}`
      } else {
        url = `${params.prefix}/${params.table}`
      }
      return url
    },
    pathMxItemUrl: function () {
      return this.pathMxItemIdC ? `${this.pathMxListUrl}/${this.pathMxItemIdC}` : false
    }
  },
  methods: {
    pathMxGetDeletePath: function (id) {
      return `${this.pathMxBasePath}/${id}/delete`
    },
    pathMxGetItemPath: function (id) {
      return `${this.pathMxBasePath}/${id}/read`
    },
    pathMxGetUpdatePath: function (id) {
      return `${this.pathMxBasePath}/${id}/update`
    },
    pathMxGoToList () {
      this.$router.push({
        path: this.pathMxListPath
      })
    }
  },
  watch: {
    pathMxItemIdP (value) {
      this.pathMxItemIdD = value
    },
    pathMxTableParentP (value) {
      JSON.parse(JSON.stringify(value))
    },
    pathMxTableNameP (value) {
      this.pathMxTableNameD = value
    }
  }
}
