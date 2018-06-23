<script>
  import UuidMx from '../mixins/UuidMx'
  import CodeMx from '../mixins/CodeMx'
  import DataMx from '../mixins/DataMx'
  import RoutingMx from '../mixins/RoutingMx'

  export default {
    name: 'base-data-component',
    mixins: [
      DataMx,
      CodeMx,
      UuidMx,
      RoutingMx
    ],
    props: {
      uuidMxRegister: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        isRequestPending: false
      }
    }
  }
</script>