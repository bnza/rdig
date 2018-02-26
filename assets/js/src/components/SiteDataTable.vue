<template>
    <base-data-table
        :items="items"
    >
        <tr slot-scope="props">
            <td>
                <base-action-item-router-link :id="props.item.id"/>
            </td>
            <td class="text-xs-right">{{ props.item.code }}</td>
            <td class="text-xs-right">{{ props.item.name }}</td>
        </tr>
    </base-data-table>
</template>

<script>
  import RSTableMx from '../mixins/RSTableMx'
  import PathMx from '../mixins/PathMx'
  import TableMx from '../mixins/TableMx'
  import BaseDataTable from './BaseDataTable'
  import BaseActionItemRouterLink from './BaseActionItemRouterLink'

  export default {
    name: 'site-data-table',
    mixins: [
      PathMx,
      RSTableMx,
      TableMx
    ],
    components: {
      BaseDataTable,
      BaseActionItemRouterLink
    },
    data () {
      return {
        items: []
      }
    }
  }
</script>
