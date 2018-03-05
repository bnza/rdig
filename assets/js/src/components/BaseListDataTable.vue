<script>
  import BaseDataTable from './BaseDataTable'
  import {routingMxListActionPath, routingMxItemActionPath} from '../mixins/RoutingMx'

  export default {
    name: 'base-list-data-table',
    extends: BaseDataTable,
    methods: {
      getPath (action, list) {
        if (list) {
          return routingMxListActionPath(action, this.table__, this.prefix, this.parent__)
        } else {
          return routingMxItemActionPath(action, this.table__, this.id__, this.prefix, this.parent__)
        }
        return fn(action, )
      },
      goToPath (action, list) {
        this.$router.push(this.getPath(action, list))
      },
      goToList (action) {
        action = action || 'read'
        this.$router.push(this.getPath(action, true))
      }
    }
  }
</script>