<script>
  import UuidMx from '../mixins/UuidMx'
  import DataMx from '../mixins/DataMx'
  import RoutingMx from '../mixins/RoutingMx'

  export default {
    name: 'base-data-component',
    mixins: [
      DataMx,
      UuidMx,
      RoutingMx
    ],
    props: {
      uuidMxRegister: {
        type: Boolean,
        default: true
      }
    },
    data () {
      return {
        isRequestPending: false
      }
    },
    created () {
      this.$emit('created', this.uuid)
    }
  }
</script>