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
    data() {
      return {
        isRequestPending: false
      }
    },
    methods: {
      getDate(date) {
        if (date) {
          date = new Date(date.date);
          return date.toLocaleDateString();
        }
      }
    }
  }
</script>