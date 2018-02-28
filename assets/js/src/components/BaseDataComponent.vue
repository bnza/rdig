<script>
  import UuidMx from '../mixins/UuidMx'
  import PathMx from '../mixins/PathMx'

  export default {
    name: 'base-data-component',
    mixins: [
      PathMx,
      UuidMx
    ],
    props: {
      uuidMxRegister: {
        type: Boolean,
        default: true
      },
      parent__: {
        type: Object,
        validator (value) {
          return value.hasOwnProperty('table') &&  value.hasOwnProperty('id')
        }
      }
    },
    data () {
      return {
        isRequestPending: false,
        prefix_: 'data',
        table_: ''
      }
    },
    computed: {
      parent: {
        get () {
          return this.uuidMxGet('parent')
        },
        set (value) {
          this.uuidMxSet('parent', value)
        }
      },
      prefix: {
        get () {
          return this.uuidMxGet('prefix')
        },
        set (value) {
          this.uuidMxSet('prefix', value)
        }
      },
      table: {
        get () {
          return this.uuidMxGet('table')
        },
        set (value) {
          this.uuidMxSet('table', value)
        }
      }
    },
    created () {
      const params = this.$route.params
      this.parent = this.parent__
      this.prefix = this.prefix_ || params.prefix
      this.table = this.table_ || params.table
    }
  }
</script>