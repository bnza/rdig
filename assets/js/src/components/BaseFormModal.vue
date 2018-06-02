<script>
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'
  import {routingMxClone, routingMxGetReadRoute, routingMxListPath} from '../mixins/RoutingMx'

  export default {
    name: 'base-form-modal',
    mixins: [
      UuidMx
    ],
    data () {
      return {
        open: true,
        to_: null,
        from: '/'
      }
    },
    computed: {
      callerUuid () {
        return this.uuidMxGet('callerUuid') || this.uuidMxGet('listDataComponentUuid', 'the-main-data')
      },
      dataFormComponent () {
        return this.$refs.dataForm
      },
      dataFormComponentName () {
        return `${pascalize(this.table)}${this.componentSuffix}`
      },
      isDialogOpen: {
        get () {
          return !!this.uuidMxGet('isDialogOpen')
        },
        set (value) {
          this.uuidMxSet('isDialogOpen', value)
        }
      },
      id () {
        return this.$route.params.childId ? this.$route.params.childId : this.$route.params.id
      },
      isSubmitButtonDisabled () {
        if (this.uuidMxGet('isInvalid')) {
          return true
        }
        return this.$refs.dataForm ? this.$refs.dataForm.isRequestPending : false
      },
      item () {
        return this.uuidMxGet('item')
      },
      parent () {
        if (this.$route.params.childTable) {
          return {
            table: this.$route.params.table,
            id:  this.$route.params.id
          }
        }
      },
      table () {
        return this.$route.params.childTable ? this.$route.params.childTable : this.$route.params.table
      },
      to () {
        return this.dataFormComponent.routingMxListPath
      }
    },
    methods: {
      closeDialog (reload) {
        this.$router.go(-1)
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        vm.from = routingMxClone(from)
      })
    }
  }
</script>