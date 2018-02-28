<script>
  import RSTableMx from '../mixins/RSTableMx'
  import TableMx from '../mixins/TableMx'
  import BaseDataComponent from './BaseDataComponent'

  export default {
    name: 'base-data-table',
    extends: BaseDataComponent,
    mixins: [
      RSTableMx,
      TableMx
    ],
    created () {
      if (this.uuid) {
        this.uuidMxSet('table', this.pathMxTableNameD)
        if (this.pathMxTableParentD) {
          this.uuidMxSet('parent', this.pathMxTableParentD)
        }
      }
    }
  }
</script>
