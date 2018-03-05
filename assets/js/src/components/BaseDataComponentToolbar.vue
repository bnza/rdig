<script>
  import RSTableMx from '../mixins/RSTableMx'
  import RoutingMx from '../mixins/RoutingMx'
  import DataMx from '../mixins/DataMx'
  import {routingMxListActionPath, routingMxItemActionPath} from '../mixins/RoutingMx'

  export default {
    name: 'base-data-component-toolbar',
    props: {
      dCuid: {
        type: String
      }
    },
    mixins: [
      DataMx,
      RoutingMx,
      RSTableMx
    ],
    computed: {
      listPath () {
       return routingMxListActionPath('read', this.table__, this.prefix, this.parent__)
      },
      itemPath () {
        return routingMxItemActionPath('read', this.table__, this.id__, this.prefix, this.parent__)
      },
      table () {
        return this.table__
      },
      color () {
        return this.parent__ ? 'blue-grey lighten-2' : 'indigo darken-4'
      },
      label () {
        return this.rsTableMxTable.label
      }
    },
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