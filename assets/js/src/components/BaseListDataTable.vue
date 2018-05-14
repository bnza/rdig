<script>
  import BaseDataTable from './BaseDataTable'
  import {routingMxListActionPath, routingMxItemActionPath} from '../mixins/RoutingMx'
  import AuthMx from '../mixins/AuthMx'

  export default {
    name: 'base-list-data-table',
    extends: BaseDataTable,
    mixins: [
      AuthMx
    ],
    methods: {
      getPath (action, list, id) {
        if (list) {
          return routingMxListActionPath(action, this.table__, this.prefix, this.parent__)
        } else {
          return routingMxItemActionPath(action, this.table__, id || this.id__, this.prefix, this.parent__)
        }
      },
      goToPath (action, list) {
        this.$router.push(this.getPath(action, list))
      },
      goToList (action) {
        action = action || 'read'
        this.$router.push(this.getPath(action, true))
      }
    },
    created () {
      this.$emit('created', this.uuid)
    }
  }
</script>