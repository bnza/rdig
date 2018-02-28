<script>
  import RSTableMx from '../mixins/RSTableMx'

  export default {
    name: 'base-data-component-toolbar',
    props: {
      parent__: {
        type: Object
      },
      table__: {
        type: String
      }
    },
    mixins: [
      RSTableMx
    ],
    computed: {
      table () {
        return this.table__
      },
      color () {
        return this.parent__ ? 'blue-grey lighten-2' : 'indigo darken-4'
      },
      label () {
        return this.rsTableMxTable.label
      }
    }
  }
</script>